<template>
    <div v-if="isLoader" class="loader-background">
        <span class="loader"/>
    </div>
</template>
<script>
export default {
    name: "Loader",
    props: {
        isLoader: {
            type: Boolean,
            default: false
        }
    }
}
</script>
<style scoped>
.loader-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 3px;
}
.loader {
    width: 48px;
    height: 48px;
    border: 5px solid #FFF;
    border-bottom-color: transparent;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
}

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>


