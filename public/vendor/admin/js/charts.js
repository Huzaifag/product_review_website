(function($) {
    "use strict";

    let usersChart = $('#users-chart');
    if (usersChart.length) {
        window.Chart && new Chart(usersChart, {
            type: 'line',
            data: {
                labels: chartsConfig.users.labels,
                datasets: [{
                    label: chartsConfig.users.title,
                    data: chartsConfig.users.data,
                    fill: false,
                    pointBackgroundColor: config.colors.primary_color,
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
                        suggestedMax: chartsConfig.users.max,
                    }
                }
            }
        });
    }

    let businessesChart = $('#businesses-chart');
    if (businessesChart.length) {
        window.Chart && new Chart(businessesChart, {
            type: 'bar',
            data: {
                labels: chartsConfig.businesses.labels,
                datasets: [{
                    label: chartsConfig.businesses.title,
                    data: chartsConfig.businesses.data,
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
                        suggestedMax: chartsConfig.businesses.max,
                    }
                }
            }
        });
    }

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
            type: 'bar',
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