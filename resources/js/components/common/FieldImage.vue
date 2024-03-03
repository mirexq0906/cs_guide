<template>
    <div class="w-full">
        <div class="font-medium mb-1" v-if="fieldTitle.length">
            {{ fieldTitle }}
        </div>
        <input class="hidden" type="file" ref="fileInput" @change="handleFileChange"/>
        <Button @click="selectFile" label="Загрузка изображения"/>
        <div class="flex align-items-center justify-content-center relative mt-2" v-if="imageUrl || modelValue">
            <Button @click="closeImage" class="absolute z-2 right-0 top-0" icon="pi pi-times" severity="danger" rounded/>
            <Image :src="imageUrl || modelValue" alt="Image"  preview/>
        </div>
    </div>
</template>
<script>
import Button from 'primevue/button';
import Image from 'primevue/image';

export default {
    name: "FieldImage",
    components: {
        Button, Image
    },
    props: {
        modelValue: {
            default: null
        },
        fieldTitle: {
            type: String,
            default: ''
        },
    },
    emits: ['update:modelValue'],
    data() {
        return {
            imageUrl: null
        }
    },
    methods: {
        handleFileChange() {
            const fileInput = this.$refs.fileInput;
            const file = fileInput.files[0];
            this.$emit('update:modelValue', file)
            if (file) {
                this.previewImage(file);
            }
        },
        previewImage(file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                this.imageUrl = e.target.result;
            };

            reader.readAsDataURL(file);
        },
        selectFile() {
            const fileInput = this.$refs.fileInput
            fileInput.value = null;
            fileInput.click();
        },
        closeImage() {
            this.imageUrl = null
            this.$emit('update:modelValue', null)
        }
    }
}
</script>


