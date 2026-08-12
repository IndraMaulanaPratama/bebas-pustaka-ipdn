<div wire:poll.5s="pollKegiatan">
    {{--
        wire:ignore WAJIB aya di dieu. Tanpa ieu, unggal polling Livewire
        bakal "morph" (nyaimbangkeun) HTML jero div ieu balik ka kaayaan
        kosong sapertos di Blade (sabab template-na mémang salawasna kosong
        — eusina/SVG chart-na disieun ku ApexCharts via JS SANGGEUS blade
        di-render, lain ti Blade), nyababkeun grafik nu geus digambar ku
        ApexCharts kahapus unggal 5 detik (persis bug nu kapendak: grafik
        leungit sanggeus auto-refresh, balik deui ngan saupami full reload).
        wire:ignore nyarengkeun Livewire supados ulah nyabak/mikirkeun eusi
        div ieu pisan, sina jadi tanggung jawab ApexCharts sagemblengna.
    --}}
    <div id="reportsChart" wire:ignore></div>

    @script
    <script>
        let chart = new ApexCharts(document.querySelector('#reportsChart'), {
            series: @js($series),
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: ['#4154f1', '#ffc107', '#2eca6a', '#ff771d'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 500]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                type: 'category',
                categories: @js($categories),
            },
            tooltip: {
                x: {
                    formatter: (value) => `Jam ${value}`,
                },
            }
        });

        chart.render();

        $wire.on('statistik-kegiatan-updated', (event) => {
            chart.updateSeries(event.series);
        });
    </script>
    @endscript
</div>
