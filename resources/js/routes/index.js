import Vue from "vue";

import VueRouter from "vue-router";
Vue.use(VueRouter);

import AppLayout from "@/js/layouts/App";

/*
**Customer Routes
*/
import Login from "@/js/pages/customers/Login";
import Register from "@/js/pages/customers/Register";
import Products from "@/js/pages/customers/Products";


/*
**Admin Routes
*/
import AdminLogin from "@/js/pages/admins/Login";
import AdminRegister from "@/js/pages/admins/Register";
import AdminProducts from "@/js/pages/admins/Products/List";
import ProductSave from "@/js/pages/admins/Products/Save";

const routes = [
    {
        path: "/",
        component: AppLayout,
        children: [
            { path: "", component: Login, name: "home" },
            { path: "login", component: Login, name: "login" },
            { path: "register", component: Register, name: "register" },
            { path: "products", component: Products, name: "products" },
            { path: "admin", component: AdminLogin, name: "admin-login" },
            { path: "admin/register", component: AdminRegister, name: "admin-register" },
            { path: "admin/products", component: AdminProducts, name: "admin-products" },
            { path: "admin/products/save/:id?", component: ProductSave, name: "admin-product-save" },
        ]
    }
];

const router = new VueRouter({
    mode: "history",
    routes,
});

router.beforeEach(async (to, from, next) => {
    let token = await localStorage.getItem("token");
    const isAuthenticated = token && token.length > 4;

    let isAdmin = false;
    let user = JSON.parse(localStorage.getItem("user"));

    if (isAuthenticated) {
        if (user.role == 'admin') {
            isAdmin = true;
        }
    }
    let guestRoutes = ["home", "login", "register","admin-login","admin-register"];
    let adminRoutes = ["admin-products", 'admin-product-save'];
    if (isAuthenticated) {
        if (isAdmin) {
            !guestRoutes.includes(to.name) && adminRoutes.includes(to.name) ? next() : next({ name: "admin-products" });
        } else {
            !guestRoutes.includes(to.name) && !adminRoutes.includes(to.name) ? next() : next({ name: "products" });
       }
    } else {
        !guestRoutes.includes(to.name) ? next({ name: "login" }) : next();
    }
});

export default router;
