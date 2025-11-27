<template>
    <div v-show="isVisible" class="modal-backdrop"></div>
    <div
        v-show="isVisible"
        class="modal fade"
        :class="{ 'show d-block': isVisible }"
        tabindex="-1"
        :aria-hidden="!isVisible"
        :aria-modal="isVisible"
        role="dialog"
        @click.self="cancel()"
    >
        <div
            class="modal-dialog modal-dialog-centered modal-dialog-scrollable m-auto max-w-60"
        >
            <div class="modal-content">
                <div class="modal-header border-0 pt-3">
                    <div class="h4 w-100 m-0 text-center">{{ title }}</div>
                </div>

                <div class="modal-body py-0">
                    <h4>{{ message }}</h4>
                </div>
                <div
                    class="text-center py-2 gap-2 d-flex justify-content-center align-items-center"
                >
                    <button
                        type="button"
                        class="btn btn-outline-secondary rounded-pill"
                        @click="cancel()"
                    >
                        {{ cancelButton }}
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary rounded-pill"
                        @click="confirm()"
                    >
                        {{ okButton }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
export default {
    name: "confirmDialog",
    data() {
        return {
            isVisible: false,
            title: "Confirm",
            message: "Are  you sure?",
            okButton: "Confirm",
            cancelButton: "Cancel",

            resolvePromise: undefined,
            rejectPromise: undefined,
        };
    },
    methods: {
        show(options = {}) {
            this.title = options["title"] ?? this.title;
            this.message = options["message"] ?? this.message;
            this.okButton = options["okButton"] ?? this.okButton;
            this.cancelButton = options["cancelButton"] ?? this.cancelButton;
            this.isVisible = true;

            return new Promise((resolve, reject) => {
                this.resolvePromise = resolve;
                this.rejectPromise = reject;
            });
        },
        confirm() {
            (this.isVisible = false), this.resolvePromise(true);
        },
        cancel() {
            (this.isVisible = false), this.resolvePromise(false);
        },
    },
};
</script>
