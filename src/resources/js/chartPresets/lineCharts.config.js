import { chartUtils } from './chart.js';

function isDarkMode() {
    return document.documentElement.classList.contains('dark');
}

// Gradient functions
function lineChartMainGradient(ctx) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    if (isDarkMode()) {
        gradient.addColorStop(0, 'rgba(128, 85, 142, 0.6)');
        gradient.addColorStop(1, 'rgba(128, 85, 142, 0)');
    } else {
        gradient.addColorStop(0, 'rgba(128, 85, 142, 0.8)');
        gradient.addColorStop(1, 'rgba(128, 85, 142, 0)');
    }
    return gradient;
}

function lineChartSecondaryGradient(ctx) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    if (isDarkMode()) {
        gradient.addColorStop(0, 'rgba(218, 94, 146, 0.6)');
        gradient.addColorStop(1, 'rgba(218, 94, 146, 0)');
    } else {
        gradient.addColorStop(0, 'rgba(218, 94, 146, 0.8)');
        gradient.addColorStop(1, 'rgba(218, 94, 146, 0)');
    }
    return gradient;
}

function lineChartTertiaryGradient(ctx) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    if (isDarkMode()) {
        gradient.addColorStop(0, 'rgba(245, 158, 11, 0.6)');
        gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');
    } else {
        gradient.addColorStop(0, 'rgba(245, 158, 11, 0.8)');
        gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');
    }
    return gradient;
}

const borderColorsLight = ['#80558E', '#DA5E92', '#F59E0B'];
const borderColorsDark = ['#C29FEA', '#F794B3', '#FBBF24'];
const gradientColors = [lineChartMainGradient, lineChartSecondaryGradient, lineChartTertiaryGradient];

export function lineChartOptions() {
    const darkMode = isDarkMode();
    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            datalabels: { display: false },
            legend: {
                padding: 8,
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    font: { size: 10 },
                    boxWidth: 15,
                    boxHeight: 12,
                    color: darkMode ? '#E5E5E5' : '#333333',
                }
            },
            tooltip: {
                backgroundColor: darkMode ? '#1F1F1F' : '#FFFFFF',
                titleColor: darkMode ? '#fff' : '#000',
                bodyColor: darkMode ? '#E5E5E5' : '#333',
                cornerRadius: 10,
                padding: 12,
                displayColors: false,
            }
        },
        scales: {
            y: {
                suggestedMin: 2,
                suggestedMax: (ctx) => chartUtils.suggestedMax(ctx.chart),
                ticks: { stepSize: 2, color: darkMode ? '#E5E5E5' : '#333' },
                grid: {
                    display: true,
                    color: darkMode ? 'rgba(255,255,255,0.1)' : '#f0f0f0',
                    drawBorder: true,
                }
            },
            x: {
                grid: { display: false, drawBorder: false },
                ticks: { color: darkMode ? '#E5E5E5' : '#333' },
            }
        }
    };
}

export function prepareLineChartDataset(dataList, type, label, ctx) {
    const datasetStyling = {
        fill: true,
        tension: 0.4,
        pointStyle: 'circle',
        pointRadius: 6,
        pointHoverRadius: 7,
        borderWidth: 1.5,
        pointBorderColor: '#DBDBDB',
    };

    const borderColors = isDarkMode() ? borderColorsDark : borderColorsLight;

    return dataList.map((dataObj, index) => ({
        ...dataObj,
        ...datasetStyling,
        backgroundColor: gradientColors[index](ctx),
        borderColor: borderColors[index],
        pointBackgroundColor: borderColors[index],
    }));
}
