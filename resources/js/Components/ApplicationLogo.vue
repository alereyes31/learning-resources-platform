<template>
    <img :src="getImageUrl('logopequeño.jpg')" alt="Descripción de la imagen" />
</template>

<script>
export default {
    methods: {
        getImageUrl(filename) {
            return `/images/${filename}`;
        },
    },
};
</script>
