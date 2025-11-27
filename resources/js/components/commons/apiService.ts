import axios from "axios";
import configurations from "./Config";
import router from "../../router";
export default class apiService {
    private base_url = configurations.env.base_url;
    private get getToken() {
        return String(localStorage.getItem("token"));
    }
    private getHeader = {
        accept: "application/json",
        Authorization: `Bearer  ${this.getToken || ""}`,
    };
    public async Get(path, data = true) {
        try {
            return await axios
                .get(path, {
                    headers: {
                        ...this.getHeader,
                        "Content-Type": "application/json",
                    },
                })
                .then((res) => {
                    return data ? res.data : res;
                })
                .catch((err) => {
                    if (
                        // err.response.status == 401 ||
                        err.response.status == 403
                    ) {
                        localStorage.clear();
                        location.reload();
                    }
                    return (
                        err.response.data || {
                            success: false,
                            message: err.message,
                        }
                    );
                });
        } catch (error) {
            console.log(error);
        }
    }
    public async Delete(path, data = true) {
        try {
            return await axios
                .delete(path, {
                    headers: {
                        ...this.getHeader,
                        "Content-Type": "application/json",
                    },
                })
                .then((res) => {
                    return data ? res.data : res;
                })
                .catch((err) => {
                    if (
                        // err.response.status == 401 ||
                        err.response.status == 403
                    ) {
                        localStorage.clear();
                        location.reload();
                    }
                    return (
                        err.response.data || {
                            success: false,
                            message: err.message,
                        }
                    );
                });
        } catch (error) {
            console.log(error);
        }
    }
    public async GetFile(path, data = true) {
        try {
            return await axios
                .get(path, {
                    headers: {
                        ...this.getHeader,
                        "Content-Type": "application/vnd.ms-excel",
                    },
                    responseType: "blob",
                })
                .then((res) => {
                    return data ? res.data : res;
                })
                .catch((err) => {
                    if (
                        // err.response.status == 401 ||
                        err.response.status == 403
                    ) {
                        localStorage.clear();
                        location.reload();
                    }
                    return (
                        err.response.data || {
                            success: false,
                            message: err.message,
                        }
                    );
                });
        } catch (error) {
            console.log(error);
        }
    }
    public async GetPdfFile(path, data = true) {
        try {
            return await axios
                .get(path, {
                    headers: {
                        ...this.getHeader,
                        "Content-Type": "application/pdf",
                    },
                    responseType: "blob",
                })
                .then((res) => {
                    return data ? res.data : res;
                })
                .catch((err) => {
                    if (
                        // err.response.status == 401 ||
                        err.response.status == 403
                    ) {
                        localStorage.clear();
                        location.reload();
                    }
                    return (
                        err.response.data || {
                            success: false,
                            message: err.message,
                        }
                    );
                });
        } catch (error) {
            console.log(error);
        }
    }

    public async Post(path, json) {
        try {
            return await axios
                .post(path, json, {
                    headers: {
                        ...this.getHeader,
                        "Content-Type": "application/json",
                    },
                })
                .then((res) => {
                    return res.data;
                })
                .catch((err) => {
                    if (
                        // err.response.status == 401 ||
                        err.response.status == 403
                    ) {
                        localStorage.clear();
                        location.reload();
                    }
                    return (
                        err.response.data || {
                            success: false,
                            message: err.message,
                        }
                    );
                });
        } catch (error) {
            console.log(error);
        }
    }
    public async PostForm(path, json) {
        try {
            return await axios
                .post(path, json, {
                    headers: {
                        ...this.getHeader,
                        "Content-Type": "multipart/form-data; ",
                    },
                })
                .then((res) => {
                    return res.data;
                })
                .catch((err) => {
                    if (
                        // err.response.status == 401 ||
                        err.response.status == 403
                    ) {
                        localStorage.clear();
                        location.reload();
                    }
                    return (
                        err.response.data || {
                            success: false,
                            message: err.message,
                        }
                    );
                });
        } catch (error) {
            console.log(error);
        }
    }

    public async logOut(type) {
        const logoutPath = type === "company" ? "logout" : "admin-logout";
        try {
            return await axios
                .post(
                    `/api/${logoutPath}`,
                    { role: localStorage.getItem("role") },
                    {
                        headers: {
                            ...this.getHeader,
                            "Content-Type": "application/json",
                        },
                    }
                )
                .then((res) => {
                    if (res.data.success) {
                        localStorage.clear();
                        // router.push("/sign-in");
                        // location.reload();
                    }
                    return res.data;
                })
                .catch((err) => {
                    if (
                        // err.response.status == 401 ||
                        err.response.status == 403
                    ) {
                        localStorage.clear();
                        location.reload();
                    }
                    return (
                        err.response.data || {
                            success: false,
                            message: err.message,
                        }
                    );
                });
        } catch (error) {
            console.log(error);
        }
    }
}
