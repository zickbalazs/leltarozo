import type { InventoryItem } from "@/classes/InventoryItem";
import type { AxiosPromise } from "axios";
import axios from 'axios';
interface params {
    table: string;
    id?: string | undefined;
    field?: string | undefined;
    value?: string | undefined;
}
interface Delete {
    message: any | undefined;
    deletedRows: number;
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
const db = {
    GetAll, Delete
}




export { db };