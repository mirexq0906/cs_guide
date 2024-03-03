<template>
    <router-view></router-view>

    <ConfirmDialog/>
    <Toast/>

</template>
<script>
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';

export default {
    components: {
        ConfirmDialog,
        Toast
    },
    data() {
        return {};
    }
}
</script>
<style>
html {
    font-size: 14px;
}

img {
    max-width: 100%;
}

*,
*::before,
*::after {
    box-sizing: border-box;
}

html {
    height: 100vh;
    font-size: 14px;
    line-height: 1.21;
}

.p-component {
    font-size: 14px;
}

.p-button {
    line-height: 1;
}

body {
    margin: 0;
    padding: 0.5rem;
    -webkit-font-smoothing: antialiased;
    height: 100%;
}

img,
picture,
video,
canvas,
svg {
    display: block;
    max-width: 100%;
}

input,
button,
textarea,
select {
    font: inherit;
}

p,
h1,
h2,
h3,
h4,
h5,
h6 {
    overflow-wrap: break-word;
}

#root,
#__next {
    isolation: isolate;
}

a {
    text-decoration: none;
    color: initial;
}

#app {
    height: 100%;
}

*,
*::before,
*::after {
    box-sizing: border-box;
}

html {
    height: 100vh;
    font-size: 14px;
    line-height: 1.21;
}

.p-component {
    font-size: 14px;
}

.p-button {
    line-height: 1;
}

body {
    margin: 0;
    padding: 0.5rem;
    -webkit-font-smoothing: antialiased;
    height: 100%;
}

img,
picture,
video,
canvas,
svg {
    display: block;
    max-width: 100%;
}

input,
button,
textarea,
select {
    font: inherit;
}

p,
h1,
h2,
h3,
h4,
h5,
h6 {
    overflow-wrap: break-word;
}

#root,
#__next {
    isolation: isolate;
}

a {
    text-decoration: none;
    color: initial;
}

#app {
    height: 100%;
}
</style>
