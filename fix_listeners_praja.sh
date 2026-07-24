#!/bin/bash
find app/Livewire/Praja -type f -name "*.php" -exec sed -i '' '/#\[On("failed-updating-data"), On("data-updated"), On("data-created"), On("failed-creating-data")\]/d' {} +
find app/Livewire/Praja -type f -name "*.php" -exec sed -i '' "/#\[On('failed-updating-data'), On('data-updated'), On('data-created'), On('failed-creating-data')\]/d" {} +
