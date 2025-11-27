<template>
    <canvas ref="canvas" id="drawing-pad">
        This is an interactive drawing pad.
    </canvas>
</template>
<script>
export default {
    data() {
        return {
            canvas: null,
            context: null,
            isDrawing: false,
            startX: 0,
            startY: 0,
            points: []
        };
    },

    methods: {
        mousedown(e) {
            var vm = this;
            var rect = vm.canvas.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;

            vm.isDrawing = true;
            vm.startX = x;
            vm.startY = y;
            vm.points.push({
                x: x,
                y: y
            });
        },
        mousemove(e) {
            var vm = this;
            var rect = vm.canvas.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;

            if (vm.isDrawing) {
                vm.context.beginPath();
                vm.context.moveTo(vm.startX, vm.startY);
                vm.context.lineTo(x, y);
                vm.context.lineWidth = 1;
                vm.context.lineCap = "round";
                vm.context.strokeStyle = "rgba(0,0,0,1)";
                vm.context.stroke();

                vm.startX = x;
                vm.startY = y;

                vm.points.push({
                    x: x,
                    y: y
                });
            }
        },
        mouseup(e) {
            var vm = this;
            vm.isDrawing = false;
            if (vm.points.length > 0) {
                localStorage["points"] = JSON.stringify(vm.points);
            }
        },
        resetCanvas() {
            var vm = this;
            vm.canvas.width = vm.canvas.width;
            vm.points.length = 0; // reset points array
        },
        saveImage() {
            var vm = this;
            var dataURL = vm.canvas.toDataURL();
            var img = vm.$refs.img;
            img.src = dataURL;
        }
    },

    mounted() {
        var vm = this;
        vm.canvas = vm.$refs.canvas;
        vm.context = vm.canvas.getContext("2d");
        vm.canvas.addEventListener("mousedown", vm.mousedown);
        vm.canvas.addEventListener("mousemove", vm.mousemove);
        document.addEventListener("mouseup", vm.mouseup);
    }
};
</script>
