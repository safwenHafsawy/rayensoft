import {lineChartOptions, prepareLineChartDataset} from './lineCharts.config.js'
import {prepareRoundChartDataset, pieChartOptions, doughnutOptions, polarAreaOptions} from './roundCharts.configs.js'
import {prepareBarChartDataset, horizontalBarChartOptions, verticalBarChartOptions} from './barCharts.config.js'


export const chartUtils = {
    suggestedMax: (chart) => {
        const allData = chart.data.datasets.flatMap(ds => ds.data);
        if (!allData.length) return 5;
        return Math.max(...allData) + 1;
    },
}

export const chartOptions = {
    lineChartOptions,
    pieChartOptions,
    doughnutOptions,
    polarAreaOptions,
    horizontalBarChartOptions,
    verticalBarChartOptions
};

export const prepareChartsFunctions = {prepareLineChartDataset, prepareRoundChartDataset, prepareBarChartDataset};


