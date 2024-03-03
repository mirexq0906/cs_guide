<template>
    <Modal v-model="visible" v-model:data="data" modal-title="Редактирование записи" :is-loader="loader"
           :is-error="isError" :error-message="errorMessage">
        <template v-slot:content>
            <div class="flex flex-column gap-3">
                <field-text v-model="data.name" field-title="Название категории"/>
                <field-image v-model="data.img"/>
            </div>
        </template>
        <template v-slot:footer>
            <Button @click="handleUpdateRecord" label="Редактировать запись" severity="warning"/>
        </template>
    </Modal>
</template>
<script>
import FieldText from "@/components/common/FieldText.vue";
import FieldImage from "@/components/common/FieldImage.vue";
import Button from 'primevue/button';
import fetchDataMixins from "@/mixins/FetchDataMixins.js";
import Modal from "@/components/common/Modal.vue";

export default {
    name: "UpdateModal",
    components: {
        Modal,
        FieldText,
        Button,
        FieldImage
    },
    mixins: [fetchDataMixins],
    emits: ['dataChange'],
    data() {
        return {
            id: null,
            visible: false,
            data: {
                name: "",
                img: null,
            }
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
        async handleUpdateRecord() {
            const formData = new FormData()
            formData.append('name', this.data.name);
            formData.append('img', this.data.img);

            const response = await this.fetchPostUpdateData(this.requestRoute, formData)
            if (response) {
                this.$emit("dataChange");
                this.visible = false
            }
        },
        async handleGetRecord() {
            const response = await this.fetchGetData(this.requestRoute);
            if (response) {
                this.data = response.payload;
            }
        },
    }

}
</script>
