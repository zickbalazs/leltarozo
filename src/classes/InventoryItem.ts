export class InventoryItem {
    public ID:number;
    public name:string;
    public leltar_nr:string;
    public price:number|null;
    public location:string|null;
    public date:Date;
    constructor(data:any){
        this.ID = data.ID;
        this.name = data.name;
        this.leltar_nr = data.leltart_nr;
        this.price = data.price;
        this.location = data.location;
        this.date = data.date;
    }
}