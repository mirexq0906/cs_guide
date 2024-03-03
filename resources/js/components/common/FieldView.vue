<template>
    <div v-if="fieldText">
        <div v-if="fieldTitle.length" class="font-medium mb-1">
            {{ fieldTitle }}
        </div>

        <Image v-if="isImg" :src="fieldText" alt="Image" :width="widthImg" preview/>

        <div v-else>
            {{ fieldText }}
        </div>
    </div>
</template>
<script>
import Image from 'primevue/image';

export default {
    name: "FieldView",
    components: {
        Image
    },
    props: {
        fieldTitle: {
            type: String,
            default: ''
        },
        fieldText: {
            type: String,
            default: ''
        },
        isImg: {
            type: Boolean,
            default: false
        },
        widthImg: {
            type: String,
            default: 'auto'
        }
    }
}
</script>


