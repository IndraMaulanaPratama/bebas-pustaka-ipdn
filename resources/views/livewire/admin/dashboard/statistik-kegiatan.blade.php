<div wire:poll.60s="pollKegiatan">
    <div id="reportsChart"></div>

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
            colors: ['#4154f1', '#2eca6a', '#ff771d'],
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
