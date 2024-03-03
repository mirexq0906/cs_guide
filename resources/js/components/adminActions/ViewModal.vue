<template>
    <Modal v-model="visible" v-model:data="data" modal-title="Просмотр записи" :is-loader="loader"
           :is-error="isError" :error-message="errorMessage" :max-width="870">
        <template v-slot:content>
            <div class="flex gap-3 mb-3">
                <div class="w-4">
                    <field-view class="mb-3" field-title="Название категории" :field-text="data?.category?.name"/>
                    <field-view field-title="Название подкатегории" :field-text="data?.sub_category?.name"/>
                </div>
                <div class="w-4">
                    <field-view class="mb-3" field-title="Начальное место" :field-text="data?.place_start?.name"/>
                    <field-view field-title="Конечное место" :field-text="data?.place_end?.name"/>
                </div>
                <div class="w-4">
                    <field-view class="mb-3" field-title="Дата создания" :field-text="data?.created_at"/>
                    <field-view field-title="Дата изменения" :field-text="data?.updated_at"/>
                </div>
            </div>
            <div class="flex gap-3">
                <field-view class="w-4" :is-img="true" field-title="Где стоять" :field-text="data?.img_start"/>
                <field-view class="w-4" :is-img="true" field-title="Куда смотреть" :field-text="data?.img_end"/>
                <field-view class="w-4" :is-img="true" field-title="Куда прилетит" :field-text="data?.img_middle"/>
            </div>
            <div>
                <div class="font-medium mb-1">
                    Изображение категории
                </div>
                <div class="relative" style="width:800px">
                    <div class="w-2rem h-2rem bg-primary absolute border-circle"
                         :style="{top: this.data?.coordinates_start?.y + 'px', left: this.data?.coordinates_start?.x + 'px'}"/>
                    <div class="w-2rem h-2rem bg-orange-500 absolute border-circle"
                         :style="{top: this.data?.coordinates_end?.y + 'px', left: this.data?.coordinates_end?.x + 'px'}"/>
                    <Image :src="this.data?.category?.img" alt="Image"/>
                </div>
            </div>
        </template>
        <template v-slot:footer>
            <Button @click="handleDeleteRecord" label="Удалить запись" severity="danger"/>
            <Button @click="$emit('openEditModal', id)" label="Редактировать запись" severity="warning"/>
        </template>
    </Modal>
</template>
<script>
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import FieldView from "@/components/common/FieldView.vue";
import Button from 'primevue/button';
import Modal from "@/components/common/Modal.vue";
import Image from 'primevue/image';
export default {
    name: "ViewModal",
    components: {
        Modal,
        FieldView,
        Button,
        Image
    },
    mixins: [fetchDataMixins],
    emits: ['openEditModal', 'dataChange'],
    data() {
        return {
            id: null,
            visible: false,
            data: {},
        };
    },
    computed: {
        requestRoute() {
            return '/actions/' + this.id;
        },
    },
    watch: {
        visible() {
            if (this.id && this.visible) {
                this.handleGetRecord()
            } else {
                this.clearError()
            }
        }
    },
    methods: {
        async handleGetRecord() {
            const response = await this.fetchGetData(this.requestRoute);
            if (response) {
                this.data = response.payload;
                this.data.coordinates_start = JSON.parse(response.payload.coordinates_start)
                this.data.coordinates_end = JSON.parse(response.payload.coordinates_end)
            }
        },
        handleDeleteRecord() {
            this.$confirm.require({
                message: 'Вы уверены, что хотите удалить запись?',
                header: 'Удаление записи',
                icon: 'pi pi-info-circle',
                rejectLabel: 'Отмена',
                acceptLabel: 'Удалить',
                rejectClass: 'p-button-secondary p-button-outlined',
                acceptClass: 'p-button-danger',
                accept: async () => {
                    const response = await this.fetchDeleteData(this.requestRoute);
                    if (response) {
                        this.visible = false
                        this.$emit('dataChange');
                    }
                },
            });
        }
    },
}
</script>
