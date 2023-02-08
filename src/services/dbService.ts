import type { InventoryItem } from "@/classes/InventoryItem";
import type { AxiosPromise } from "axios";
import axios from 'axios';
interface params {
    table: string;
    ID?: string | undefined;
    field?: string | undefined;
    value?: string | undefined;
    data?: object | undefined;
}
interface Delete {
    message: any | undefined;
    deletedRows: number;
}
interface Update{
    message: any | undefined;
    affectedRows:number;
}
function GetAll(url: string, params: params): AxiosPromise < Array < InventoryItem >> {
    return axios.get(url, {
        params: params
    });
};
function Delete(url: string, params: params): AxiosPromise < Delete > {
    return axios.delete(url, {
        data: params
    });
};
function Modify(url:string, params:params):AxiosPromise < Update >{
    return axios.patch(url, params);
}
const db = {
    GetAll, Delete, Modify
}




export { db };