<template>
    <div class="left-side-menu left-side-menu-detached">
        <div class="leftbar-user">
            <a href="javascript: void(0);">
                <img src="/assets/images/users/avatar-1.jpg" alt="user-image" height="42"
                    class="rounded-circle shadow-sm" />
                <span class="leftbar-user-name" v-if="role === 'user'">{{name}}</span>
                <span class="leftbar-user-name" v-if="role === 'admin'">{{name}}</span>
            </a>
        </div>
        <!--- Sidemenu -->
        <ul class="metismenu side-nav">
            <li class="side-nav-title side-nav-item">Menu</li>

            <li class="side-nav-item" v-if="role === 'user'">
                <router-link :to="{ path: '/tender-list' }">
                    <a class="side-nav-link">
                        <i class="uil-calender"></i>
                        <span> Tender list </span>
                    </a>
                </router-link>
            </li>

            <li class="side-nav-item" v-if="role === 'admin'">
                <router-link :to="{ path: '/admin-import' }">
                    <a class="side-nav-link">
                        <i class="uil-comments-alt"></i>
                        <span> Import </span>
                    </a>
                </router-link>
            </li>

            <li class="side-nav-item" v-if="role === 'admin'">
                <router-link :to="{ path: '/admin-settings' }">
                    <a class="side-nav-link">
                        <i class="uil-comments-alt"></i>
                        <span> Settings </span>
                    </a>
                </router-link>
            </li>

            <li class="side-nav-item" v-if="role === 'admin'">
                <router-link :to="{ path: '/company-logo' }">
                    <a class="side-nav-link">
                        <i class="uil-comments-alt"></i>
                        <span> Company Logo </span>
                    </a>
                </router-link>
            </li>
        </ul>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
        <!-- Sidebar -left -->
    </div>
</template>

<script>
    export default {
        name: "sidebar",
        data() {
            return {
                role: '',
                name: ''
            }
        },

        mounted() {
            if (this.$ls.get('authorization')) {
                this.role = this.$ls.get('role');
                this.name = this.$ls.get('name');
            }
        }
    };

</script>
