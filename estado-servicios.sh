#!/bin/bash

# Crear archivo JSON
hacer_json="/var/www/html/estado_servicios.json"

servicios=('apache2' 'ssh' 'hostapd' 'wg-quick@wg0' 'dnsmasq' 'netdata' 'cron')

ver_servicios() {
    resultados=()

    for servicio in "${servicios[@]}";
    do
        estado=$(systemctl list-units --type=service | grep "$servicio" | awk '{print $3}')
        funcionando=$(systemctl list-units --type=service | grep "$servicio" | awk '{print $4}')

        resultado="$servicio:$estado:$funcionando"
        resultados+=("$resultado")
    done
}

traducir_resultados() {
    for entrada in "${resultados[@]}";
    do
        servicio=$(echo "$entrada" | awk -F: '{print $1}')
        estado=$(echo "$entrada" | awk -F: '{print $2}')
        funcionando=$(echo "$entrada" | awk -F: '{print $3}')

        echo "Servicio: $servicio"

        case "$estado" in
        active)
          echo "Está activo"
          ;;
        *)
          echo "No está activo"
          ;;
        esac

        case "$funcionando" in
        running)
          echo "Esta funcionando"
          ;;
        *)
          echo "No está funcionando"
          ;;
        esac

        echo " "

    done
}

generar_json() {
    echo "[" > "$hacer_json"
    for i in "${!resultados[@]}"; do
        entrada="${resultados[$i]}"
        servicio=$(echo "$entrada" | awk -F: '{print $1}')
        estado=$(echo "$entrada" | awk -F: '{print $2}')
        funcionando=$(echo "$entrada" | awk -F: '{print $3}')

        echo " {" >> "$hacer_json"
        echo "    \"servicio\": \"$servicio\"," >> "$hacer_json"
        echo "    \"estado\": \"$estado\"," >> "$hacer_json"
        echo "    \"funcionando\": \"$funcionando\"" >> "$hacer_json"

        if [ "$i" -lt $(( ${#resultados[@]} - 1 )) ]; then
            echo " }," >> "$hacer_json"
        else
            echo " }" >> "$hacer_json"
        fi
    done
    echo "]" >> "$hacer_json"
}

ver_servicios
traducir_resultados
generar_json
