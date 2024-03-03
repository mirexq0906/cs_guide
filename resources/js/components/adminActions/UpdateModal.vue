<template>
    <Modal v-model="visible" v-model:data="data" modal-title="Просмотр записи" :is-loader="loader" :is-error="isError"
           :error-message="errorMessage" :max-width="870">
        <template v-slot:content>
            <div class="flex flex-column gap-3">
                <field-dropdown v-model="data.category_id" field-title="Название категории" field-label="name"
                                field-value="id" :field-data="categories" field-placeholder="Выберите категорию"/>
                <field-dropdown v-model="data.sub_category_id" field-title="Название категории" field-label="name"
                                field-value="id" :field-data="sub_categories"
                                field-placeholder="Выберите подкатегорию"/>
                <div class="flex gap-3">
                    <field-dropdown v-model="data.place_start_id" field-title="Начальное место" field-label="name"
                                    field-value="id" :field-data="places" field-placeholder="Выберите место"/>
                    <field-dropdown v-model="data.place_end_id" field-title="Конечное место" field-label="name"
                                    field-value="id" :field-data="places" field-placeholder="Выберите место"/>
                </div>
                <field-text v-model="data.desc" field-title="Описание действия"/>
                <div class="flex gap-3">
                    <field-image v-model="data.img_start" field-title="Где стоять"/>
                    <field-image v-model="data.img_end" field-title="Куда смотреть"/>
                    <field-image v-model="data.img_middle" field-title="Куда прилетит"/>
                </div>
                <div class="flex gap-3">
                    <field-number class="w-6" v-model="data.coordinates_start.x" field-title="Начальная точка X"/>
                    <field-number class="w-6" v-model="data.coordinates_start.y" field-title="Начальная точка Y"/>
                </div>
                <div class="flex gap-3">
                    <field-number class="w-6" v-model="data.coordinates_end.x" field-title="Конечная точка X"/>
                    <field-number class="w-6" v-model="data.coordinates_end.y" field-title="Конечная точка Y"/>
                </div>
                <div v-if="getImage">
                    <div class="font-medium mb-1">
                        Изображение категории
                    </div>
                    <div class="relative" style="min-width:800px">
                        <div class="w-2rem h-2rem bg-primary absolute border-circle"
                             :style="{top: this.data.coordinates_start.y + 'px', left: this.data.coordinates_start.x + 'px'}"/>
                        <div class="w-2rem h-2rem bg-orange-500 absolute border-circle"
                             :style="{top: this.data.coordinates_end.y + 'px', left: this.data.coordinates_end.x + 'px'}"/>
                        <Image :src="getImage" alt="Image"/>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:footer>
            <Button @click="handleUpdateRecord" label="Редактировать запись" severity="warning"/>
        </template>
    </Modal>
</template>
<script>
import FieldText from "@/components/common/FieldText.vue";
import Button from 'primevue/button';
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import Modal from "@/components/common/Modal.vue";
import FieldDropdown from "@/components/common/FieldDropdown.vue";
import FieldNumber from "@/components/common/FieldNumber.vue";
import FieldImage from "@/components/common/FieldImage.vue";
import Image from 'primevue/image';

export default {
    name: "UpdateModal",
    components: {
        FieldDropdown,
        Modal,
        FieldText,
        Button,
        FieldNumber,
        Image,
        FieldImage
    },
    mixins: [fetchDataMixins],
    emits: ['dataChange'],
    data() {
        return {
            visible: false,
            id: null,
            data: {
                category_id: null,
                sub_category_id: null,
                place_start_id: null,
                place_end_id: null,
                coordinates_start: {
                    x: 0, y: 0
                },
                coordinates_end: {
                    x: 0, y: 0
                },
                desc: '',
                img_start: null,
                img_end: null,
                img_middle: null,
            },
            categories: [],
            sub_categories: [],
            places: [],
            requestCategories: '/categories',
            requestSubCategories: '/sub_categories',
            requestPlaces: '/places',
        };
    },
    computed: {
        getImage() {
            return this.categories.find(item => item.id === this.data.category_id)?.img;
        },
        requestRoute() {
            return '/actions/' + this.id;
        },
    },
    watch: {
        visible() {
            if (this.visible) {
                this.handleGetRecord()
                this.handleGetCategoriesRecord()
            } else {
                this.clearError()
            }
        },
        'data.category_id'(newValue) {
            this.handleGetSubCategoriesRecord(newValue)
        },
        'data.sub_category_id'() {
            this.handleGetPlacesRecord()
        }
    },
    methods: {
        async handleUpdateRecord() {
            const formData = new FormData()
            formData.append('place_start_id', this.data.place_start_id);
            formData.append('place_end_id', this.data.place_end_id);
            formData.append('img_start', this.data.img_start);
            formData.append('img_end', this.data.img_end);
            formData.append('img_middle', this.data.img_middle);
            formData.append('coordinates_start', JSON.stringify(this.data.coordinates_start));
            formData.append('coordinates_end', JSON.stringify(this.data.coordinates_end));
            formData.append('desc', this.data.desc);
            formData.append('category_id', this.data.category_id);
            formData.append('sub_category_id', this.data.sub_category_id);
            const response = await this.fetchPostUpdateData(this.requestRoute, formData)
            if (response) {
                this.$emit("dataChange");
                this.visible = false
            }
        },
        async handleGetRecord() {
            console.log(this.requestRoute)
            const response = await this.fetchGetData(this.requestRoute);
            if (response) {
                this.data = response.payload;
                this.data.coordinates_start = JSON.parse(response.payload.coordinates_start)
                this.data.coordinates_end = JSON.parse(response.payload.coordinates_end)
            }
        },
        async handleGetSubCategoriesRecord(id) {
            let filter = {
                field: 'category_id',
                operator: "equal",
                value: String(id)
            }
            const response = await this.fetchGetData(this.requestSubCategories, {filters: [filter]})
            if (response) {
                this.sub_categories = response.payload
            }
        },
        async handleGetCategoriesRecord() {
            const response = await this.fetchGetData(this.requestCategories)
            if (response) {
                this.categories = response.payload
            }
        },
        async handleGetPlacesRecord() {
            let filter = [
                {
                    field: 'category_id',
                    operator: "equal",
                    value: String(this.data.category_id)
                },
                {
                    field: 'sub_category_id',
                    operator: "equal",
                    value: String(this.data.sub_category_id)
                }
            ]
            const response = await this.fetchGetData(this.requestPlaces, {filters: filter})
            if (response) {
                this.places = response.payload
            }
        }
    }

}
</script>
