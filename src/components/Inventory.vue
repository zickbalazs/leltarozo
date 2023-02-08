<template>
    <div class="modal modal-xl fade" tabindex="-1" id="inventoryModal">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light bg-gradient">
                    <h5 class="modal-title">Leltár</h5>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#.</th>
                                <th>Tétel neve</th>
                                <th>Leltári szám</th>
                                <th class="text-end">Értéke</th>
                                <th>Hely</th>
                                <th>Dátum</th>
                                <th>Műveletek</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in Inventory">
                                <td v-for="(value, key) in item" :class="key=='price'?'text-end':''">
                                    <span v-if="!editor.enabled || editor.editingID!=item.ID">{{ key == "price" ? new Intl.NumberFormat('hu-HU', {style:'currency', currency:'HUF'}).format(value as number) : key=="date" ? new Date((value as Date).toString()).toLocaleString('hu-HU') : value }}</span>
                                    <input v-else :type="key=='date' ? 'datetime-local': key=='ID' || key == 'price' ? 'number' : 'text'" class="form-control" :disabled="key=='ID'" v-model="editor.itemData[key]">
                                </td>
                                <td class="d-lg-flex align-items-center justify-content-around border-start mx-auto" v-if="!editor.enabled || editor.editingID!=item.ID">
                                    <button class="btn btn-warning" @click="()=>{EnableMod(item.ID)}"><i class="bi bi-wrench"></i></button>
                                    <button class="btn btn-danger" @click="()=>{Delete(item.ID)}"><i class="bi bi-trash2"></i></button>
                                </td>
                                <td class="d-lg-flex align-items-center justify-content-around border-start" v-else>
                                    <button class="btn btn-success" @click="()=>{Mod(editor.editingID)}" ><i class="bi bi-check-lg"></i></button>
                                    <button class="btn btn-danger" @click="CancelEdit"><i class="bi bi-x-lg"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <p>Összesen: {{ TotalValue }}</p>
                    <p>{{ ArrayLength }} elem</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
    import type { InventoryItem } from '@/classes/InventoryItem';
    import { db } from '@/services/dbService';
    export default {
        data(){
            return{
                Inventory:[] as Array<InventoryItem>,
                editor:{
                    enabled: false as boolean,
                    editingID: {} as number,
                    itemData: {} as InventoryItem
                }
            }
        },
        methods:{
            Delete(id:number){
                db.Delete('http://localhost/2-14-SZFT/Backend/PhP/api/api.php', {
                    table:'tetelek',
                    ID: id.toString()
                }).then(result=>{
                    this.Inventory.splice(this.Inventory.map(e=>e.ID).indexOf(id), 1);
                }).catch(err=>{
                    alert('Internal server error!');
                })
            },
            EnableMod(id:number){
                this.editor.enabled = true;
                this.editor.editingID = id;
                this.editor.itemData = this.Inventory[this.Inventory.map(e=>e.ID).indexOf(this.editor.editingID)];
            },
            Mod(id:number){
                db.Modify('http://localhost/2-14-SZFT/Backend/PhP/api/api.php', {
                    table: "tetelek",
                    ID:id.toString(),
                    data:this.editor.itemData
                }).then(results=>{
                    this.Inventory[this.Inventory.map(e=>e.ID).indexOf(this.editor.editingID)] = this.editor.itemData;
                    this.ResetEditor();
                }).catch(err=>{
                    console.log(err.response);
                })
            },
            CancelEdit(){
                this.editor.enabled = false;
                this.editor.editingID = -1;
            },
            ResetEditor(){
                this.editor.enabled = false;
                this.editor.editingID = -1;
                this.editor.itemData = {} as InventoryItem;
            }
        },
        computed:{
            ArrayLength():number{
                return this.Inventory.length;
            },
            TotalValue():string{
                return this.Inventory.length == 0 ? new Intl.NumberFormat('hu-HU', {
                    style:"currency",
                    currency:"HUF"
                }).format(0) : new Intl.NumberFormat('hu-HU',{
                    style:"currency",
                    currency:"HUF"
                } ).format(this.Inventory.map(e=> e.price==null ? 0 : Number(e.price)).reduce((a,b)=>a+b));
            }
        },
        mounted(){
            (document.querySelector('#inventoryModal') as HTMLElement).addEventListener('show.bs.modal', ()=> {
                db.GetAll('http://localhost/2-14-SZFT/Backend/PhP/api/api.php', {table:'tetelek'}).then(res=>{
                    this.Inventory = res.data;
                });
            })
        }
    }
</script>
<style>
.shrink-enter-active, .shrink-leave-active{
    transition: transform 0.2s;
    transform:scale(100%);
}
.shrink-enter-from,
.shrink-leave-to {
    transform: scale(0%);
}
</style>