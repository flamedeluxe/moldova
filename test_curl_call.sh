#!/bin/bash

# Данные для запроса
API_KEY="8v7lygho7jb61aa7e7gwlqz6horeuqe2"
API_SALT="sux7mpqilsripo5gbjok484gxb10h6ua"

# JSON данные
JSON='{
  "from": {
    "extension": "908"
  },
  "to_number": "79311071200",
  "command_id": "test_'$(date +%s)'"
}'

# Формируем подпись
SIGN=$(echo -n "$API_KEY$JSON$API_SALT" | sha256sum | cut -d' ' -f1)

# Отправляем запрос
curl -v -X POST "https://app.mango-office.ru/vpbx/commands/callback" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "vpbx_api_key=$API_KEY" \
  -d "sign=$SIGN" \
  -d "json=$JSON" 