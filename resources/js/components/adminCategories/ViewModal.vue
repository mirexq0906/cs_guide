<template>
    <Modal v-model="visible" v-model:data="data" modal-title="Просмотр записи" :max-width="650" :is-loader="loader"
           :is-error="isError" :error-message="errorMessage">
        <template v-slot:content>
            <div class="flex gap-3">
                <div class="w-6">
                    <field-view class="mb-3" field-title="Название категории" :field-text="data?.name"/>
                    <field-view :is-img="true" field-title="Изображение категории" :field-text="data?.img"/>
                </div>
                <div class="w-6">
                    <field-view class="mb-3" field-title="Дата создания" :field-text="data?.created_at"/>
                    <field-view field-title="Дата изменения" :field-text="data?.updated_at"/>
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

export default {
    name: "ViewModal",
    components: {
        Modal,
        FieldView,
        Button,
    },
    mixins: [fetchDataMixins],
    emits: ['openEditModal', 'dataChange'],
    data() {
        return {
            id: null,
            visible: false,
            data: {}
        };
    },
    computed: {
        requestRoute() {
            return '/categories/' + this.id;
        }
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
