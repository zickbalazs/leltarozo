import type {ChartConfiguration, ChartType} from 'chart.js';
export class ChartData{
    public chartName:string;
    public chartId:string;
    private type:ChartType;
    private labels:Array<string>;
    private datasets:Array<Dataset>;
    public ChartConfig:ChartConfiguration;
    constructor(name:string, canvasID:string ,type:string, labels:Array<string>, datasets:Array<Dataset>){
        this.chartName = name;
        this.chartId = canvasID;
        this.labels = labels;
        this.type = this.DetermineType(type);
        this.datasets = datasets;
        this.ChartConfig = this.GenerateChartConfig();
    }
    //DON'T ASK IT JUST WORKS
    private DetermineType(type:string):ChartType{
        switch (type){
            case "bar": return "bar";
            case "line": return "line";
            case "pie": return "pie";
            case "radar": return "radar";
            default: return "bar";
        }
    }
    private GenerateChartConfig():ChartConfiguration{
        return {
            type: this.type,
            data:{
                datasets:this.datasets,
                labels:this.labels
            },
            options:{
                plugins:{
                    title:{
                        display:true,
                        text:this.chartName
                    }
                }
            }
        };
    }
}

interface Dataset{
    labels:Array<string>;
    data:Array<number>;
    backgroundColors:Array<string>;
}