export class DashCardItem {
    public title:string;
    public icon:string;
    public gradient:Array<string>;
    constructor(title:string, icon:string, colors:Array<string>){
        this.title = title;
        this.icon = icon;
        this.gradient = colors;
    }
}