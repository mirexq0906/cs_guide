export default {
    data() {
        return {
            copyData: ''
        }
    },
    methods: {
        clearModal() {
            this.$emit('update:data', JSON.parse(this.copyData))
        }
    },
    mounted() {
        this.copyData = JSON.stringify(this.data);
    }
}
