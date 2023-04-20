<script setup>
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { nextTick, ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
//----------------//
//objetos del back
//_______________//
const props = defineProps({
    product: {
        type: Object,
    },
    countCartGlobal: {
        type: Number,
    },
});
const nextPage = () => {
    Inertia.get(props.product.next_page_url);
};

const prevPage = () => {
    Inertia.get(props.product.prev_page_url);
};
const formatCurrency = (value) => {
    if (value) {
        const formatter = new Intl.NumberFormat("es-CO", {
            style: "currency",
            currency: "COP",
        });
        return formatter.format(value);
    } else {
        return "";
    }
};
const newProducts = ref(
    props.product.data.map((product) => ({ ...product, add: false }))
);

console.log("productos", newProducts);
// vatiables
const countCartGlobal = ref(0);
const productCart = ref([]);
const count = ref(1);
const discount = ref(0);
let displayModalCart = ref(false);
//funciones
// al dar click se muestra el carrito de compras
function showModalCart() {
    displayModalCart.value = ref(true);
}

const sumTotalGlobal = () => {
    return +productCart.value.reduce((acumulador, productCart) => {
        return acumulador + productCart.price * productCart.amount;
    }, 0);
};

const sendPrice = async () => {
    const datos = {};
    const url = "/product/send-mail"; // especifica la URL del controlador de Laravel

    try {
        const response = await axios.post(url, datos);
        console.log(response.data); // haz algo con la respuesta del controlador, si lo necesitas
    } catch (error) {
        console.error(error);
    }
};

const emit = defineEmits(["count-cart-global"]);

function increment(id) {
    // Buscamos el objeto con el id buscado y le sumamos 1 a la propiedad 'amount'
    const object = productCart.value.find((object) => object.id === id);
    object.amount += 1;

    // Actualizamos el valor de 'productCart' para reflejar el cambio
    const indice = productCart.value.findIndex((object) => object.id === id);
    productCart.value.splice(indice, 1, object);

    countProductGlobalMore();
}

function decrement(id) {
    // Buscamos el objeto con el id buscado y le sumamos 1 a la propiedad 'amount'
    const object = productCart.value.find((object) => object.id === id);
    if (object.amount > 0) {
        object.amount -= 1;
    }

    // Actualizamos el valor de 'productCart' para reflejar el cambio
    const indice = productCart.value.findIndex((object) => object.id === id);
    productCart.value.splice(indice, 1, object);

    countProductGlobalLess();
}
function addCart(id, url_file, name, price) {
    productCart.value.push({
        id: id,
        product: url_file,
        name: name,
        price: price,
        amount: 1,
    });

    stateCart(id);
    countProductGlobalMore();
}

function countProductGlobalMore() {
    countCartGlobal.value += 1;
}

function countProductGlobalLess() {
    if (countCartGlobal.value > 0) {
        countCartGlobal.value -= 1;
    }
}

function stateCart(id) {
    const product = newProducts.value.find((p) => p.id === id);
    product.add = true;
    console.log(productCart.value);
}

function deleteProduct(id) {
    const index = productCart.value.findIndex((p) => p.id === id);
    const productDelete = productCart.value.find((p) => p.id === id);
    console.log("index", index);
    if (index !== -1) {
        productCart.value.splice(index, 1);
    }
    if (countCartGlobal.value > 0) {
        countCartGlobal.value -= productDelete.amount;
    }
}
</script>

//styles
<style lang="css" scoped>
hr {
    background-color: black;
    height: 1px;
}

.pagination {
    margin-top: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
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
    <AuthenticatedLayout
        @open-modal-cart="showModalCart"
        :countCartGlobal="countCartGlobal"
    >
        <div class="row">
            <div
                class="pt-3 pb-0 col-6"
                v-for="item in newProducts"
                :key="item.id"
            >
                <div class="">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-4 row">
                            <div class="col-md-4">
                                <img :src="item.url_file" class="w-96" />
                            </div>
                            <div class="col-md-6">
                                <p class="font-sans font-bold pt-4 mb-0">
                                    {{ item.name }}
                                </p>
                                <span class="font-sans mb-0"
                                    ><b>Codigo : </b>
                                </span>
                                <span class="font-sans mb-0">{{
                                    item.code
                                }}</span>
                                <hr />
                                <p class="font-arial mb-0"><b>Precio</b></p>
                                <span class="font-sans">{{
                                    formatCurrency(item.price)
                                }}</span>
                                <span class="ml-12" v-if="item.add === false">
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
                                <span v-else class="ml-12">
                                    <SecondaryButton>
                                        Agregado
                                    </SecondaryButton>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagination mt-4">
                <button
                    class="mr-4 bg-blue-900 pr-3 pt-1 pb-1 pl-3 text-white rounded-md"
                    :disabled="!product.prev_page_url"
                    @click="prevPage"
                >
                    Anterior
                </button>
                <span
                    >Página {{ product.current_page }} de
                    {{ product.last_page }}</span
                >
                <button
                    class="ml-4 bg-blue-900 pr-3 pt-1 pb-1 pl-3 text-white rounded-md"
                    :disabled="!product.next_page_url"
                    @click="nextPage"
                >
                    Siguiente
                </button>
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
                        <Column field="price" header="Precio">
                            <template #body="slotProps">
                                {{ formatCurrency(slotProps.data.price) }}
                            </template>
                        </Column>
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
                                {{
                                    formatCurrency(
                                        slotProps.data.price *
                                            slotProps.data.amount
                                    )
                                }}
                            </template>
                        </Column>
                        <Column field="" header="Acciones">
                            <template #body="slotProps">
                                <i
                                    @click="deleteProduct(slotProps.data.id)"
                                    class="pi pi-trash"
                                    style="color: red"
                                ></i>
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
                                id="discount"
                                type="discount"
                                class="form-control text-right mt-4"
                                v-model="discount"
                                required
                                placeholder="Descuento"
                                autocomplete="current-password"
                                autofocus
                            />
                        </div>
                    </div>
                    <div class="flex flex-col items-end mt-4">
                        <div class="flex justify-between w-full mb-2">
                            <span><b>Subtotal:</b></span>
                            <span>{{ formatCurrency(sumTotalGlobal()) }}</span>
                        </div>
                        <div class="flex justify-between w-full mb-2">
                            <span><b>Descuento:</b></span>
                            <span
                                >{{
                                    formatCurrency(discount)
                                        ? formatCurrency(discount)
                                        : "$ " + 0
                                }}
                            </span>
                        </div>
                        <!-- <div class="flex justify-between w-full mb-2">
                            <span><b>Iva:</b></span>
                            <span>$50000</span>
                        </div> -->
                        <div class="flex justify-between w-full mb-2">
                            <span><b>Total:</b></span>
                            <span>{{
                                formatCurrency(sumTotalGlobal() - discount)
                            }}</span>
                        </div>
                    </div>

                    <div class="flex justify-end items-end mt-4">
                        <PrimaryButton @click="sendPrice"
                            >Enviar cotización</PrimaryButton
                        >
                    </div>
                </form>
            </Dialog>
        </div>
    </AuthenticatedLayout>
</template>
