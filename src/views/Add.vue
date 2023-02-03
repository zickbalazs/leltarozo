<template>
    <div class="modal fade" tabindex="-1" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Leltár</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tétel neve</label>
                        <input type="text" name="name" v-model="newItem.name" class="form-control"
                            placeholder="Tételnév">
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Hely</label>
                        <input type="text" name="location" v-model="newItem.location" class="form-control"
                            placeholder="Tétel helye">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Értéke</label>
                        <input type="number" min="0" step="100" name="price" v-model="newItem.price"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Leltározási Dátum</label>
                        <input type="datetime-local" name="date" v-model="newItem.date" class="form-control">
                    </div>
                    <label for="leltarnr" class="form-label">Leltári szám</label>
                    <div class="mb-3 input-group">
                        <input type="text" name="leltarnr" v-model="newItem.leltart_nr" class="form-control"
                            placeholder="LRM1000">
                        <button for="leltarnr" class="input-group-text btn-success btn"
                            :disabled="!IDGenRequirementsFilled"
                            @click="() => { newItem.leltart_nr = GenID }">Generálás</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success bg-gradient" @click="AddItem" :disabled="!EverythingFilled">Hozzáadás</button>
                </div>
            </div>
        </div>
    </div>

</template>
<script lang="ts">
import axios from 'axios';
interface Data {
    name: string,
    leltart_nr: string,
    price: number | null,
    location: string | null,
    date: string
}
export default {
    data() {
        return {
            newItem: {} as Data
        }
    },
    computed: {
        GenID(): string {
            this.newItem.leltart_nr = "";
            let dt = new Date(this.newItem.date);
            return `${this.newItem.name.slice(0, 5).toUpperCase()}-${(this.newItem.location as string).toUpperCase()}-${dt.getFullYear()}${dt.getMonth()}${dt.getDate()}`
        },
        IDGenRequirementsFilled(): boolean {
            return (this.newItem.date != null && this.newItem.location != null && this.newItem.name != null) && (
                this.newItem.date != undefined && this.newItem.location != undefined && this.newItem.name != undefined) &&
                (new Date(this.newItem.date).toString() != "Invalid Date" && this.newItem.location != "" && this.newItem.name != "");
        },
        EverythingFilled():boolean{
            return (this.newItem.date!=undefined && this.newItem.leltart_nr!=undefined && this.newItem.name!=undefined) && (this.newItem.date.toString()!="Invalid Date" && this.newItem.leltart_nr!="");
        }
    },
    methods: {
        AddItem() {
            if (this.EverythingFilled){
                let data = {
                    table:'tetelek',
                    data:{
                        name:this.newItem.name,
                        leltart_nr:this.newItem.leltart_nr,
                        price:this.newItem.price==undefined||this.newItem.price==null? null:this.newItem.price,
                        date:new Date(this.newItem.date).toISOString(),
                        location:this.newItem.location==undefined||this.newItem.location==null||this.newItem.location==""?null:this.newItem.location
                    }
                }
                axios.post('http://localhost/2-14-SZFT/Backend/PhP/api/api.php', data).then(res=>{
                    console.log(res);
                    this.newItem = {} as Data;
                }).catch(err=>{
                    console.error(err);
                })
            }
        }
    },
}
</script>