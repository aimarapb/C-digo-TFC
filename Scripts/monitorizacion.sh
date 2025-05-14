#!/bin/bash

# Crear archivo JSON
crear_json="/var/www/html/datos.json"

# Variables para el JSON
temperatura=$(vcgencmd measure_temp | cut -d= -f2 | sed "s/'C//")
ip_local=$(hostname -I | awk '{print $1}')
ip_publica=$(curl -s ifconfig.me)
uso_cpu=$(top -bn1 | grep "%Cpu" | awk '{print 100 - $8}')
uptime=$(uptime -p)
memoria=$(free -h | awk '/^Mem:/ {print $3 " usada, " $4 " libre, " $2 " total"}')
memoria_usada=$(free -h | awk '/^Mem:/ {print $3}')
memoria_libre=$(free -h | awk '/^Mem:/ {print $4}')
memoria_total=$(free -h | awk '/^Mem:/ {print $2}')
disco=$(df -h / | awk 'NR==2 {print $3 " usado, " $4 " disponible, " $2 " total"}')
disco_usado=$(df -h / | awk 'NR==2 {print $3}')
disco_libre=$(df -h / | awk 'NR==2 {print $4}')
disco_total=$(df -h / | awk 'NR==2 {print $2}')
conexion=$(ping -q -c 1 -W 1 8.8.8.8 > /dev/null && echo "Sí" || echo "No")
conectados=$(iw dev wlan0 station dump | grep -c "^Station")
info_conectados=$(arp -an | grep wlan0 | grep -v "<incomplete>" | awk '{print $2, $3, $4}')

# Generar JSON
cat <<EOF > "$crear_json"
{
  "temperatura": "$temperatura",
  "ip_local": "$ip_local",
  "ip_publica": "$ip_publica",
  "uso_cpu": "$uso_cpu",
  "uptime": "$uptime",
  "memoria_usada": "$memoria_usada",
  "memoria_libre": "$memoria_libre",
  "memoria_total": "$memoria_total",
  "disco_usado": "$disco_usado",
  "disco_libre": "$disco_libre",
  "disco_total": "$disco_total",
  "conexion": "$conexion",
  "conectados": "$conectados",
  "info_conectados": "$info_conectados"
}
EOF
