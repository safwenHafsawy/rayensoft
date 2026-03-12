const chartColors = [
    "#80558E", "#DA5E92", //  brand colors
    "#F59E0B", "#3B82F6", "#10B981",
    "#EF4444", "#A855F7", "#0EA5E9", "#1F2937"
];

export function polarAreaOptions(suffix) {
    const isDark = document.documentElement.classList.contains('dark');
    return {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            r: {
                beginAtZero: true,

                ticks: {
                    color: '#6B7280',
                    backdropColor: 'transparent',
                    font: {size: 12}
                },
                grid: {
                    color: isDark ? 'rgba(209,213,219,0.1)' : 'rgba(209,213,219,0.9)'
                },
                angleLines: {
                    color: 'rgba(209,213,219,0.9)'
                }
            }
        },
        plugins: {
            datalabels: {
                display: false,
            },
            tooltip: {
                backgroundColor: '#1F1F1F',
                titleColor: '#fff',
                bodyColor: '#E5E5E5',
                cornerRadius: 10,
                padding: 12,
                callbacks: {
                    title: (context) => {
                        const label = context[0].label || '';
                        const datasetLabel = context[0].dataset.label || '';
                        if (label === 'Other' || label === 'Unknown') return `${datasetLabel} ${label} ${suffix}`;

                        return `${datasetLabel} ${label}`;

                    },
                    label: function (context) {
                        const value = context.formattedValue || '';
                        const sum = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / sum) * 100).toFixed(1) + '%';
                        return `${value} / ${sum} (${percentage})`;
                    }
                }
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'rectRot',
                    color: !isDark ? '#212121' : '#fdfdfd',
                    font: {size: 10}
                }
            },
        },
    }
}

export function doughnutOptions(suffix) {
    return {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '30%',
        onClick: (event, elements) => {
            if (elements.length > 0) {
                const datasetIndex = elements[0].datasetIndex;
                myChart.data.datasets.splice(datasetIndex, 1); // remove whole dataset
                myChart.update();
            }
        },
        plugins: {
            datalabels: {
                color: '#fff',
                font: {weight: 'bold', size: 10},
                formatter: (value, ctx) => {
                    const sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    const percentage = ((value / sum) * 100).toFixed(1) + '% ';

                    const label = ctx.chart.data.labels[ctx.dataIndex];
                    return `${label} : ${value} \n(${percentage})`;
                }
            },
            legend: {
                display: false,
                position: 'bottom',
                labels: {
                    color: '#374151',
                    font: {size: 12, weight: '600'}
                }
            },
            tooltip: {
                backgroundColor: '#1F1F1F',
                titleColor: '#fff',
                bodyColor: '#E5E5E5',
                cornerRadius: 10,
                padding: 12,

                displayColors: false,
                callbacks: {
                    title: function (context) {
                        const label = context[0].label || '';
                        const datasetLabel = context[0].dataset.label || '';

                        if (label === 'Other' || label === 'Unknown') return `${datasetLabel}  ${label} ${suffix}`;
                        return `${datasetLabel} ${label}`;
                    },
                    label: function (context) {
                        const value = context.formattedValue || '';
                        const sum = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / sum) * 100).toFixed(1) + '% ';
                        return `${value} / ${sum} (${percentage})`;
                    }
                }
            }
        }
    }
}

export function pieChartOptions(suffix) {
    return {
        responsive: true,
        maintainAspectRatio: false,
        cutout: "2%",
        plugins: {
            datalabels: {
                color: '#fff',
                font: {weight: 'bold', size: 9},
                formatter: (value, ctx) => {
                    const sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    const percentage = ((value / sum) * 100).toFixed(1) + '% ';
                    // Get the label (the "key")
                    let label = ctx.chart.data.labels[ctx.dataIndex];

                    if (label.length > 10) {
                        label = label.substring(0, 10) + '...';
                    }

                    return `${label} : ${value} \n(${percentage})`;
                }
            },
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1F1F1F',
                titleColor: '#fff',
                bodyColor: '#E5E5E5',
                cornerRadius: 10,
                padding: 12,
                displayColors: false,
                callbacks: {
                    title: function (context) {
                        const label = context[0].label || '';
                        const datasetLabel = context[0].dataset.label || '';

                        if (label === 'Other' || label === 'Unknown') return `${datasetLabel} ${label} ${suffix}`;

                        return `${datasetLabel} ${label}`;
                    },
                    label: function (context) {
                        const value = context.formattedValue || '';
                        const sum = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);

                        const percentage = ((value / sum) * 100).toFixed(1) + '% ';
                        return `${value} / ${sum} - (${percentage})`;
                    }
                }
            }
        }
    }
}


export function prepareRoundChartDataset(dataList, type, label) {
    let datasetStyling = {
        backgroundColor: label.map((_, i) => chartColors[i % chartColors.length]),
        offset: 5,
        hoverOffset: 10,
        borderWidth: 1,
        borderRadius: 5
    }

    return dataList.map((dataObj) => {
        return {
            ...dataObj,
            ...datasetStyling,
        };
    });
}
