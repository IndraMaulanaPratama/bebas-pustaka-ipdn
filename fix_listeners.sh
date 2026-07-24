#!/bin/bash
find app/Livewire/Admin -type f -name "*.php" -exec sed -i '' '/#\[On("data-rejected"), On("failed-updating-data"), On("data-updated")\]/d' {} +
find app/Livewire/Admin -type f -name "*.php" -exec sed -i '' "/#\[On('data-rejected'), On('failed-updating-data'), On('data-updated')\]/d" {} +
