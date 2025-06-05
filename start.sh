#!/bin/bash

echo "🏘️  Iniciando Conecta Bairro..."

# Backend Laravel
echo "📍 Iniciando Backend Laravel..."
cd back
php artisan serve --host=127.0.0.1 --port=8000 &

# Frontend Web (servidor simples)
echo "🌐 Iniciando Frontend Web..."
cd ../front
python3 -m http.server 3000 &

echo "✅ Serviços iniciados:"
echo "   🔧 API Laravel: http://127.0.0.1:8000"
echo "   🌐 Frontend Web: http://127.0.0.1:3000"
echo ""
echo "📱 Para o mobile Flutter:"
echo "   cd mobile && flutter run"
echo ""
echo "Para parar os serviços, pressione Ctrl+C"

wait 