<template>
    <div
        class="modal-backdrop opacity-75 bg-primary-subtle position-fixed z-index-max"
    ></div>
    <div
        class="d-flex justify-content-center align-items-center text-primary loader-container fps-spinner"
    >
        <div>
            <div v-for="x in 12" :key="x" class="wheel"></div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.loader-container {
    width: 100vw;
    height: 100vh;
    position: fixed;
    z-index: 999999;
}
.z-index-max {
    z-index: 9999;
}
.fps-spinner .wheel {
    animation: fps-spinner 1.2s linear infinite;
}
.fps-spinner .wheel:after {
    content: " ";
    display: block;
    position: fixed;
    top: 24px;
    left: 0px;
    width: 8px;
    height: 30px;
    border-radius: 50%;
    background: var(--ct-primary);
}
.fps-spinner .wheel:nth-child(1) {
    transform: rotate(0deg);
    animation-delay: -1.1s;
}
.fps-spinner .wheel:nth-child(2) {
    transform: rotate(30deg);
    animation-delay: -1s;
}
.fps-spinner .wheel:nth-child(3) {
    transform: rotate(60deg);
    animation-delay: -0.9s;
}
.fps-spinner .wheel:nth-child(4) {
    transform: rotate(90deg);
    animation-delay: -0.8s;
}
.fps-spinner .wheel:nth-child(5) {
    transform: rotate(120deg);
    animation-delay: -0.7s;
}
.fps-spinner .wheel:nth-child(6) {
    transform: rotate(150deg);
    animation-delay: -0.6s;
}
.fps-spinner .wheel:nth-child(7) {
    transform: rotate(180deg);
    animation-delay: -0.5s;
}
.fps-spinner .wheel:nth-child(8) {
    transform: rotate(210deg);
    animation-delay: -0.4s;
}
.fps-spinner .wheel:nth-child(9) {
    transform: rotate(240deg);
    animation-delay: -0.3s;
}
.fps-spinner .wheel:nth-child(10) {
    transform: rotate(270deg);
    animation-delay: -0.2s;
}
.fps-spinner .wheel:nth-child(11) {
    transform: rotate(300deg);
    animation-delay: -0.1s;
}
.fps-spinner .wheel:nth-child(12) {
    transform: rotate(330deg);
    animation-delay: 0s;
}
@keyframes fps-spinner {
    0% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
}
</style>
