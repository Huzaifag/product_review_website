(function($) {
    "use strict";

    let reviewsChart = $('#reviews-chart');
    if (reviewsChart.length) {
        window.Chart && new Chart(reviewsChart, {
            type: 'line',
            data: {
                labels: chartsConfig.reviews.labels,
                datasets: [{
                    label: chartsConfig.reviews.title,
                    data: chartsConfig.reviews.data,
                    fill: false,
                    pointBackgroundColor: config.colors.primary_color,
                    borderWidth: 2,
                    borderColor: config.colors.primary_color,
                    lineTension: .10,
                    rtl: config.direction == "rtl" ? true : false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            drawBorder: true
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 17
                        }
                    },
                    y: {
                        suggestedMax: chartsConfig.reviews.max,
                        grid: {
                            drawBorder: true
                        }
                    }
                }
            }
        });
    }

    let viewsChart = $('#views-chart');
    if (viewsChart.length) {
        window.Chart && new Chart(viewsChart, {
            type: 'line',
            data: {
                labels: chartsConfig.views.labels,
                datasets: [{
                    label: chartsConfig.views.title,
                    data: chartsConfig.views.data,
                    fill: false,
                    backgroundColor: config.colors.primary_color,
                    borderColor: config.colors.primary_color,
                    borderWidth: 2,
                    lineTension: .10,
                    rtl: config.direction == "rtl" ? true : false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            drawBorder: true
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 17
                        }
                    },
                    y: {
                        suggestedMax: chartsConfig.views.max,
                        grid: {
                            drawBorder: true
                        }
                    }
                }
            }
        });
    }

})(jQuery);