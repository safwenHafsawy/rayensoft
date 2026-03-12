import {chartUtils} from "./chart.js";

const barCharStyles = {
    horizontalBarChartGradient(ctx) {
        const isDark = document.documentElement.classList.contains('dark');
        const gradient = ctx.createLinearGradient(0, 0, ctx.canvas.width, 0);

        if (isDark) {
            gradient.addColorStop(0, '#b5658f'); // softer pink
            gradient.addColorStop(0.5, '#9c4f78'); // muted mid-tone
            gradient.addColorStop(1, '#5e3c65'); // deep purple
        } else {
            gradient.addColorStop(0, '#e07aa0'); // lighter pink
            gradient.addColorStop(0.5, '#c4668e'); // middle tone
            gradient.addColorStop(1, '#80558E'); // original purple
        }

        return gradient;
    },

    horizontalBarChartHoverGradient(ctx) {
        const isDark = document.documentElement.classList.contains('dark');
        const gradient = ctx.createLinearGradient(0, 0, ctx.canvas.width, 0);

        if (isDark) {
            gradient.addColorStop(0, '#7a4b66');
            gradient.addColorStop(0.5, '#a35c82');
            gradient.addColorStop(1, '#d86b9a');
        } else {
            gradient.addColorStop(0, '#5a3d63');
            gradient.addColorStop(0.5, '#8c5075');
            gradient.addColorStop(1, '#c45483');
        }

        return gradient;
    },

    verticalBarChartGradient(ctx) {
        const isDark = document.documentElement.classList.contains('dark');
        const gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);

        if (isDark) {
            gradient.addColorStop(0, '#b5658f');
            gradient.addColorStop(0.5, '#9c4f78');
            gradient.addColorStop(1, '#5e3c65');
        } else {
            gradient.addColorStop(0, '#e07aa0');
            gradient.addColorStop(0.5, '#c4668e');
            gradient.addColorStop(1, '#80558E');
        }

        return gradient;
    },

    verticalBarChartHoverGradient(ctx) {
        const isDark = document.documentElement.classList.contains('dark');
        const gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);

        if (isDark) {
            gradient.addColorStop(0, '#d86b9a');
            gradient.addColorStop(0.5, '#a35c82');
            gradient.addColorStop(1, '#3a263f');
        } else {
            gradient.addColorStop(0, '#c45483');
            gradient.addColorStop(0.5, '#9b4a7a');
            gradient.addColorStop(1, '#483050');
        }

        return gradient;
    },
};


export function horizontalBarChartOptions(suffix, darkModeColors) {
    return {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            datalabels: {
                font: {size: 0},
            },
            tooltip: {
                backgroundColor: '#1F1F1F',
                titleColor: '#fff',
                bodyColor: '#e5e5e5',
                padding: 14,
                borderWidth: 1,
                cornerRadius: 20,
                displayColors: false,
                callbacks: {
                    title: (context) => {
                        const label = context[0].label;
                        const datasetLabel = context[0].dataset.label || '';
                        if (label === 'Unknown') return 'Unknown';
                        return `${datasetLabel} ${label}`;
                    },
                        label: (context) => {
                            const value = context.formattedValue || '';
                            const sum = context.chart.data.datasets[0].data.reduce((a, b) => a + Number(b), 0);
                            const percentage = ((value / sum) * 100).toFixed(1);

                            return `${value} / ${sum} - ${percentage}%`;
                        }
                }
            },
            legend: {
                display: false,
            }
        },
        scales: {
            y: {
                title: {
                    display: false,
                },
                border: {display: false},
                grid: {display: false},
                ticks: {
                    color: darkModeColors['text'],
                    font: { size: 12, weight: '600' },
                    precision: 0,
                },
            },
            x: {
                suggestedMax: (ctx) => chartUtils.suggestedMax(ctx.chart),
                grid: {
                    color: darkModeColors['grid'],
                },
                ticks: {
                    color: darkModeColors['text'],
                    font: { size: 12, weight: '600' },
                    precision: 0,
                },
            }
        }
    }
}

export function verticalBarChartOptions(suffix, darkModeColors) {
    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            datalabels: {
                font: {  size: 0 },
            },
            tooltip: {
                backgroundColor: '#1F1F1F',
                titleColor: '#fff',
                bodyColor: '#e5e5e5',
                padding: 14,
                borderColor: '#80558E',
                borderWidth: 1,
                cornerRadius: 12,
                displayColors: false,
                callbacks: {
                    title: (context) => context[0].label,
                    label: (context) => `${context.dataset.label}: ${context.formattedValue}`
                }
            },
            legend: {
                display: false,
                position: 'bottom',
                usePointStyle: true,
                pointStyle: 'circle',
                labels: {
                    color: darkModeColors['text'],
                    font: { size: 13, weight: '600' }
                }
            }
        },
        scales: {
            y: {
                suggestedMin: 0,
                suggestedMax: (ctx) => chartUtils.suggestedMax(ctx.chart),
                grid: { color: darkModeColors['grid'] },
                ticks: {
                    color: darkModeColors['text'],
                    font: { size: 12, weight: '600' },
                    precision: 0,
                },
                beginAtZero: true,
                title: {
                    display: true,
                    color: darkModeColors['text'],
                    font: { size: 10, style: 'italic', weight: '400' },
                    padding: { top: 0, bottom: 15 }
                }
            },
            x: {
                grid: { color: darkModeColors['grid'], drawTicks: true },
                border: { display: true },
                ticks: {
                    color: darkModeColors['text'],
                    font: { size: 12 },
                    callback: function(value) {
                        const label = this.getLabelForValue(value);
                        return label.length > 15 ? label.slice(0, 15) + '…' : label;
                    }
                },
                beginAtZero: true
            }
        }
    }
}

export function prepareBarChartDataset(dataList, type, label, ctx) {
    const prefix = type === 'horizontalBar' ? 'horizontalBar' : 'verticalBar';
    const isDark = document.documentElement.classList.contains('dark');
    const backgroundColor = barCharStyles[`${prefix}ChartGradient`](ctx);
    const hoverBackgroundColor = barCharStyles[`${prefix}ChartHoverGradient`](ctx);

    let datasetStyling = {
        backgroundColor: backgroundColor,
        borderColor: isDark ? '#2F2F2F' : '#DBDBDB',
        borderRadius: 20,
        barThickness: 25,
        borderWidth: 5,
        hoverBackgroundColor: hoverBackgroundColor,
        hoverBorderColor: '#fff',
    }

    return dataList.map((dataObj) => {
        return {
            ...dataObj,
            ...datasetStyling,
        };
    });
}
