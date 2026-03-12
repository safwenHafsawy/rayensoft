import "./bootstrap";
import Chart from "chart.js/auto";
import ChartDataLabels from 'chartjs-plugin-datalabels';
// import "trix";
// import "trix/dist/trix.css";

import {
    chartOptions,
    prepareChartsFunctions
} from './chartPresets/chart.js'

Chart.register(ChartDataLabels);

const isDarkMode = document.documentElement.classList.contains('dark');

const darkModeColors = isDarkMode
    ? {
        background: '#1F2937', // dark bg
        grid: '#262626',        // dark grid lines
        text: '#F9FAFB',        // labels
    }
    : {
        background: '#F9FAFB', // light bg
        grid: '#D1D5DB',       // light grid lines
        text: '#1F2937',       // labels
    };

function createChart(ctx, params) {
    let {type, dataList, label, tooltipSuffix} = params;

    let datasets;
    let options;

    switch (type) {
        case 'polarArea':
            options = chartOptions.polarAreaOptions(tooltipSuffix, darkModeColors);
            datasets = prepareChartsFunctions.prepareRoundChartDataset(dataList, type, label);
            break;
        case 'doughnut':
            options = chartOptions.doughnutOptions(tooltipSuffix,darkModeColors);
            datasets = prepareChartsFunctions.prepareRoundChartDataset(dataList, type, label);
            break;
        case 'pie' :
            options = chartOptions.pieChartOptions(tooltipSuffix, darkModeColors);
            datasets = prepareChartsFunctions.prepareRoundChartDataset(dataList, type, label);
            break;
        case 'horizontalBar' :
            datasets = prepareChartsFunctions.prepareBarChartDataset(dataList, type, label, ctx);
            options = chartOptions.horizontalBarChartOptions(tooltipSuffix, darkModeColors);
            break;
        case 'verticalBar' :
            datasets = prepareChartsFunctions.prepareBarChartDataset(dataList, type, label,ctx);
            options = chartOptions.verticalBarChartOptions(tooltipSuffix, darkModeColors);
            break;
        case 'line' :
            options = chartOptions.lineChartOptions(darkModeColors);
            datasets = prepareChartsFunctions.prepareLineChartDataset(dataList, type, label, ctx);
    }

    if (type === 'verticalBar' || type === 'horizontalBar') type = 'bar';

    return new Chart(ctx, {
        type: type,
        data: {
            labels: label,
            datasets: datasets
        },
        options
    })
}


Window.chartsConfigs = {
    createChart,
}




