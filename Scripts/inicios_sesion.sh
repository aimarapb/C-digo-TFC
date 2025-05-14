#!/bin/bash

# De donde recibe los datos
archivo_entrada="/var/www/html/inicios_sesion.txt"
# Salida de los datos
archivo_salida="/var/www/html/inicios_sesion.json"

# A partir de los datos que recibe los tranforma en formato JSON para el archivo de salida
hacer_json() {
    echo "[" > "$archivo_salida"

    total=$(grep -c "Usuario:" "$archivo_entrada")
    contador=0

    while IFS= read -r linea; do
        # Saltar líneas vacías
        [[ -z "$linea" ]] && continue

        contador=$((contador + 1))
        fecha=$(echo "$linea" | awk -F ' - Usuario: ' '{print $1}')
        usuario=$(echo "$linea" | awk -F ' - Usuario: ' '{print $2}')

        echo "  {" >> "$archivo_salida"
        echo "    \"fecha\": \"$fecha\"," >> "$archivo_salida"
        echo "    \"usuario\": \"$usuario\"" >> "$archivo_salida"

        if [ "$contador" -lt "$total" ]; then
            echo "  }," >> "$archivo_salida"
        else
            echo "  }" >> "$archivo_salida"
        fi
    done < "$archivo_entrada"

    echo "]" >> "$archivo_salida"
}

case "$1" in
    inicios)
        hacer_json
        ;;
    *)
        echo "Uso: $0 inicios"
        exit 1
        ;;
esac
