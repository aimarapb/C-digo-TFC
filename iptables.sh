#!/bin/bash
# Eliminar iptables anteriores
sudo iptables -F
sudo iptables -t nat -F
sudo iptables -X

# Establecer politicas predeterminadas
sudo iptables -P INPUT DROP
sudo iptables -P FORWARD DROP
sudo iptables -P OUTPUT ACCEPT

# Para conexiones establecidas de entrada y salida (conexiones ya establecidas)
sudo iptables -A INPUT -m conntrack --ctstate RELATED,ESTABLISHED -j ACCEPT
sudo iptables -A FORWARD -m conntrack --ctstate RELATED,ESTABLISHED -j ACCEPT

# Configurar NAT para acceso a internet
sudo iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE

# Permitir trafico de la VPN hacia la red Wi-Fi
sudo iptables -A FORWARD -i eth0 -o wlan0 -m state --state RELATED,ESTABLISHED -j ACCEPT
sudo iptables -A FORWARD -i wlan0 -o eth0 -j ACCEPT

sudo iptables -A INPUT -i wg0 -j ACCEPT
sudo iptables -A FORWARD -i wg0 -j ACCEPT

# Permitir el trafico de la VPN
sudo iptables -A INPUT -p udp --dport 51820 -j ACCEPT

# Permitir el trafico en el loopback
sudo iptables -A INPUT -i lo -j ACCEPT
sudo iptables -A OUTPUT -o lo -j ACCEPT

# Permitir el trafico de la conexion ssh y HTTP/HTTPS
sudo iptables -A INPUT -p tcp --dport 22 -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 80 -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 443 -j ACCEPT

# Guardar las reglas
sudo iptables-save > /etc/iptables/rules.v4
