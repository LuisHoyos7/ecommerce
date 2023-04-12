<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { nextTick, ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
//----------------//
//objetos del back
//_______________//
defineProps({
    product: {
        type: Object,
    },
});

//funciones
function showModalCart() {
    displayModalCart.value = ref(true);
}
const productCart = ref([]);
const count = ref(1);
const discount = ref(0);

function increment(id) {
    // Buscamos el objeto con el id buscado y le sumamos 1 a la propiedad 'amount'
    const objetoEncontrado = productCart.value.find(
        (objeto) => objeto.id === id
    );
    objetoEncontrado.amount += 1;

    // Actualizamos el valor de 'productCart' para reflejar el cambio
    const indice = productCart.value.findIndex((objeto) => objeto.id === id);
    productCart.value.splice(indice, 1, objetoEncontrado);
}

function decrement(id) {
    if (count.value > 0) {
        count.value--;
    }
}
function addCart(id, url_file, name, price) {
    productCart.value.push({
        id: id,
        product: url_file,
        name: name,
        price: price,
        amount: 1,
    });
    console.log(productCart.value);
}
//data
let displayModalCart = ref(false);
</script>

//styles
<style lang="css" scoped>
hr {
    background-color: black;
    color: black;
    height: 2px;
}
.counter {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100px;
    height: 30px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.counter button {
    font-size: 1rem;
    font-weight: bold;
    border-radius: 50%;
    border: none;
    cursor: pointer;
}

.counter span {
    font-size: 0.7rem;
    font-weight: bold;
    text-align: center;
    width: 20px;
}
</style>
>

<template>
    <!--Recibo el emit desde el nav para poder abrir el modal de las compras (el detalle del carrito de compras)-->
    <AuthenticatedLayout @open-modal-cart="showModalCart">
        <div class="row">
            <div class="pt-6 pb-0 col-6" v-for="item in product" :key="item.id">
                <div class="">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-4 row">
                            <div class="col-md-4">
                                <img :src="item.url_file" class="w-96" />
                            </div>
                            <div class="col-md-6">
                                <p class="font-mono font-bold pt-4 mb-0">
                                    {{ item.name }}
                                </p>
                                <span class="font-mono mb-0">Codigo : </span>
                                <span class="font-mono mb-0">{{
                                    item.code
                                }}</span>
                                <hr />
                                <p class="font-mono mb-0">PRECIO</p>
                                <span class="font-mono">{{ item.price }}</span>
                                <span class="ml-16">
                                    <PrimaryButton
                                        @click="
                                            addCart(
                                                item.id,
                                                item.url_file,
                                                item.name,
                                                item.price
                                            )
                                        "
                                    >
                                        Añadir al carrito
                                    </PrimaryButton>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Dialog
                v-model:visible="displayModalCart"
                modal
                header="Orden"
                :style="{ width: '80vw' }"
            >
                <div class="pl-9 pr-9">
                    <DataTable
                        :value="productCart"
                        paginator
                        :rows="2"
                        tableStyle="min-width: 50rem"
                        class="p-datatable-sm"
                    >
                        <Column field="id" header="Producto">
                            <template #body="slotProps">
                                <img
                                    class="w-12"
                                    :src="slotProps.data.product"
                                />
                            </template>
                        </Column>
                        <Column
                            field="name"
                            header="Descripción del producto"
                        ></Column>
                        <Column field="price" header="Precio"></Column>
                        <Column field="amount" header="Cantidad">
                            <template #body="slotProps">
                                <div class="counter">
                                    <button
                                        @click="decrement(slotProps.data.id)"
                                    >
                                        -
                                    </button>
                                    <span>{{ slotProps.data.amount }}</span>
                                    <button
                                        @click="increment(slotProps.data.id)"
                                    >
                                        +
                                    </button>
                                </div>
                            </template>
                        </Column>
                        <Column field="total" header="Total">
                            <template #body="slotProps">
                                {{ slotProps.data.price * count }}
                            </template>
                        </Column>
                        <Column field="" header="Eliminar">
                            <template #body="slotProps">
                                <DangerButton>Eliminar</DangerButton>
                            </template>
                        </Column>
                    </DataTable>
                </div>
                <form action="">
                    <div class="flex justify-end items-end">
                        <div>
                            <!-- <InputLabel
                                for="password"
                                value="Descuento"
                                class="text-right mb-1 mt-3"
                                placeholder="Descuento"
                            /> -->
                            <input
                                id="discont"
                                type="discont"
                                class="form-control text-right mt-4"
                                v-model="discont"
                                required
                                placeholder="Descuento"
                                autocomplete="current-password"
                                autofocus
                            />
                        </div>
                    </div>
                    <div class="flex justify-end items-end mt-4">
                        <span><b>Subtotal: </b></span><span>$50000</span>
                    </div>
                    <div class="flex justify-end items-end mt-2">
                        <span><b>Descuento: </b></span><span>$50000</span>
                    </div>
                    <div class="flex justify-end items-end mt-2">
                        <span><b>Iva: </b></span><span>$50000</span>
                    </div>
                    <div class="flex justify-end items-end mt-2">
                        <span><b>Total: </b></span><span>$50000</span>
                    </div>
                    <div class="flex justify-end items-end mt-4">
                        <PrimaryButton
                            >Enviar cotización (por definir)</PrimaryButton
                        >
                    </div>
                </form>
            </Dialog>
        </div>
    </AuthenticatedLayout>
</template>
