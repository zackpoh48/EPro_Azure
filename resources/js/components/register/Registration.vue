<template>
    <div v-if="is_verified">
        <div class="account-pages mt-4">
            <!-- <loader v-if="loading"></loader> -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card">
                            <div
                                class="card-header pt-4 pb-4 text-center bg-primary"
                            >
                                <a href="#">
                                    <span
                                        ><img
                                            :src="companyLogoUrl"
                                            alt="logo"
                                            width="100"
                                    /></span>
                                </a>
                            </div>

                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto">
                                    <h4
                                        class="text-dark-50 text-center mt-0 font-weight-bold"
                                    >
                                        Additional verification is required
                                    </h4>
                                </div>

                                <form
                                    @submit="
                                        passcodeVerification(
                                            $event,
                                            'verification'
                                        )
                                    "
                                >
                                    <div class="form-group">
                                        <label for="passcode" class="form-label"
                                            >Enter the passcode provided</label
                                        >
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="passcode"
                                            v-model="
                                                passcode_verification.passcode
                                            "
                                            v-bind:class="{
                                                'is-invalid': errors.passcode,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.passcode }}
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 text-center">
                                        <button
                                            class="btn btn-primary mt-2"
                                            type="button"
                                            @click="
                                                passcodeVerification(
                                                    $event,
                                                    'verification'
                                                )
                                            "
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="supplier-registration" class="mt-3" v-else-if="form.status === 0">
        <!-- <loader v-if="loading"></loader> -->
        <!-- Form Starts -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- card Header -->
                    <div class="card-header pt-4 pb-4 text-center bg-primary">
                        <a href="#">
                            <span
                                ><img
                                    :src="companyLogoUrl"
                                    alt="logo"
                                    width="100"
                            /></span>
                        </a>
                    </div>
                    <!-- card body -->
                    <div class="card-body">
                        <form class="needs-validation" novalidate>
                            <!-- Form title -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <h3 class="mb-3 mt-0 text-center">
                                            Supplier Registration
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <!-- Section A -->
                            <div class="w-100 p-2 bg-light p-2 mb-3">
                                <h5 class="m-0">A. Organisation Particular</h5>
                            </div>
                            <div class="row px-2">
                                <!-- Company name -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom01"
                                            >Name of Company <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="50"
                                            placeholder="Name of Company"
                                            v-model="form.name_of_company"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.name_of_company,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.name_of_company }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Company Reg No -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom02"
                                            >Company Reg. No. <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="20"
                                            placeholder="Company Reg. No."
                                            v-model="form.company_reg_no"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.company_reg_no,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.company_reg_no }}
                                        </div>
                                    </div>
                                </div>


                                 <!-- <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom02" class="form-label">
                                            SST Registration No. <span style="color:red">*</span>
                                        </label>
                                        <div class="row">
                                            <div class="col-sm-6 mb-2">
                                                <input
                                                    type="text"
                                                    id="validationCustom02"
                                                    class="form-control"
                                                    maxlength="20"
                                                    placeholder="SST Registration No."
                                                    v-model="form.sst_registration_no"
                                                    v-bind:class="{ 'is-invalid': errors.sst_registration_no }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errors.sst_registration_no }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->


                                <!-- Registered Address -->
                                 <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom02"
                                        >
                                            Registered Address Line 1<span style="color:red">*</span></label
                                        >
                                        <div class="row">
                                            <div class="col-sm-6 mb-2">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="50"
                                                    placeholder="Registered Address"
                                                    v-model="
                                                        form.registered_address_one
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.registered_address_one,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{
                                                        errors.registered_address_one
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom02">
                                            Registered Address Line 2</label
                                        >
                                        <div class="row">
                                            <div class="col-sm-6 mb-2">
                                                <input
                                                type="text"
                                                class="form-control"
                                                maxlength="50"
                                                placeholder="Registered Address"
                                                v-model="
                                                    form.registered_address_two
                                                "
                                                v-bind:class="{
                                                    'is-invalid':
                                                        errors.registered_address_two,
                                                }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{
                                                        errors.registered_address_two
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mailing Address -->
                                <div class="w-100">
                                    <div class="col-sm-6"></div>
                                    
                                    <div class="col-sm-6"></div>
                                    
                                </div>

                                <!-- Zip  City Country -->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    >City <span style="color:red">*</span></label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="30"
                                                    placeholder="City"
                                                    v-model="form.city"
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.city,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errors.city }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    >State <span style="color:red">*</span></label
                                                >
                                                <select
                                                    class="form-select"
                                                    v-model="form.state"
                                                    v-bind:class="{
                                                        'is-invalid': errors.state,
                                                    }"
                                                >
                                                    <option disabled value=null>Select state</option>
                                                      <option v-for="state in states" :key="state.code" :value="state.name"
                                                      >
                                                        {{ state.name }}
                                                    </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ errors.state }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    >Country <span style="color:red">*</span></label
                                                >
                                                <select
                                                    class="form-select"
                                                    v-model="form.country"
                                                    v-bind:class="{
                                                        'is-invalid': errors.country,
                                                    }"
                                                >
                                                    <option disabled value=null>Select Country</option>
                                                      <option v-for="country in countries" :key="country.code" :value="country.code"
                                                      >
                                                        {{ country.name }}
                                                    </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ errors.country }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    >Zip Code <span style="color:red">*</span></label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="20"
                                                    placeholder="Zip Code"
                                                    v-model="form.zip_code"
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.zip_code,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errors.zip_code }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div
                                        class="custom-control custom-checkbox mb-2"
                                    >
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="mailing-address-same-as-registered-address"
                                            v-model="form.mailing_address_same_as_registered_address"
                                            @change="copyMailingAddress"
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="mailing-address-same-as-registered-address"
                                            >Mailing address same as registered address?</label
                                        >
                                    </div>
                                </div>
                                
                                <div class="col-12 mt-3">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom02"
                                        >
                                            Mailing Address Line 1 <span style="color:red">*</span></label
                                        >
                                        <div class="row">
                                            <div class="col-sm-6 mb-2">        
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="50"
                                                    placeholder="Mailing Address"
                                                    v-model="
                                                        form.mailing_address_one
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.mailing_address_one,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errors.mailing_address_one }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom02">
                                            Mailing Address Line 2 </label
                                        >
                                        <div class="row">
                                            <div class="col-sm-6 mb-2">    
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="50"
                                                    placeholder="Mailing Address"
                                                    v-model="
                                                        form.mailing_address_two
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.mailing_address_two,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errors.mailing_address_two }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mailing Address -->
                                <div class="w-100">
                                    <div class="col-sm-6"></div>
                                    
                                    <div class="col-sm-6"></div>
                                    
                                </div>

                                <!-- Zip  City Country -->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    >Mailing City <span style="color:red">*</span></label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="30"
                                                    placeholder="City"
                                                    v-model="form.mailing_address_city"
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.mailing_address_city,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errors.mailing_address_city }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    >Mailing State <span style="color:red">*</span></label
                                                >
                                                <select
                                                    class="form-select"
                                                    v-model="form.mailing_address_state"
                                                    v-bind:class="{
                                                        'is-invalid': errors.mailing_address_state,
                                                    }"
                                                >
                                                    <option disabled selected value=null>Select state</option>
                                                      <option v-for="state in states" :key="state.code" :value="state.name"
                                                      >
                                                        {{ state.name }}
                                                    </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ errors.mailing_address_state }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    >Mailing Country</label
                                                >
                                                <select
                                                    class="form-select"
                                                    v-model="form.mailing_address_country"
                                                    v-bind:class="{
                                                        'is-invalid': errors.mailing_address_country,
                                                    }"
                                                >
                                                    <option disabled selected value=null>Select Country</option>
                                                      <option v-for="country in countries" :key="country.code" :value="country.code"
                                                      >
                                                        {{ country.name }}
                                                    </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ errors.mailing_address_country }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    >Mailing Zip Code <span style="color:red">*</span></label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="20"
                                                    placeholder="Mailing Zip Code"
                                                    v-model="form.mailing_address_zip_code"
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.mailing_address_zip_code,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errors.mailing_address_zip_code }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Telephone -->
                                <div class="col-sm-6 mt-3">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom01"
                                            >Telephone Number <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="tel"
                                            class="form-control"
                                            maxlength="30"
                                            placeholder="Telephone Number"
                                            v-model="form.tel_no"
                                            @keypress="
                                                onKeypress($event, form.tel_no)
                                            "
                                            v-bind:class="{
                                                'is-invalid': errors.tel_no,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.tel_no }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Fax -->
                                <div class="col-sm-6 mt-3">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom02"
                                            >Fax Number </label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="30"
                                            placeholder="Fax Number"
                                            v-model="form.fax_no"
                                            v-bind:class="{
                                                'is-invalid': errors.fax_no,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.fax_no }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Company Website -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom01"
                                            >Company Website </label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="80"
                                            placeholder="Company Website"
                                            v-model="form.company_website"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.company_website,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.company_website }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Email Address -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom02"
                                            >Email Address </label
                                        >
                                        <input
                                            type="email"
                                            class="form-control"
                                            maxlength="80"
                                            placeholder="Email Address"
                                            v-model="form.email_address"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.email_address,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.email_address }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Type of company -->
                                <div class="col-12">
                                    <div class="form-group mb-1">
                                        <label class="d-block form-label"
                                            >Type of Company <span style="color:red">*</span></label
                                        >
                                        <div class="w-100">
                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <select
                                                            type="text"
                                                            class="form-select"
                                                            v-model="
                                                                form.type_of_company
                                                            "
                                                            v-bind:class="{
                                                                'is-invalid':
                                                                    errors.type_of_company,
                                                            }"
                                                            v-on:change="
                                                                delete form.type_of_company_other
                                                            "
                                                        >
                                                            <option
                                                                :value="null"
                                                            >
                                                                Select
                                                            </option>
                                                            <option
                                                                value="Sole Proprietor"
                                                            >
                                                                Sole Proprietor
                                                            </option>
                                                            <option
                                                                value="Partnership"
                                                            >
                                                                Partnership
                                                            </option>
                                                            <option
                                                                value="Private Limited"
                                                            >
                                                                Private Limited
                                                            </option>
                                                            <option
                                                                value="Public Listed"
                                                            >
                                                                Public Listed
                                                            </option>
                                                            <option
                                                                value="Others (Please Specify)"
                                                            >
                                                                Others (Please
                                                                Specify)
                                                            </option>
                                                        </select>
                                                        <div
                                                            class="invalid-feedback"
                                                        >
                                                            {{
                                                                errors.type_of_company
                                                            }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-12 col-sm-6"
                                                    v-if="
                                                        form.type_of_company ===
                                                        'Others (Please Specify)'
                                                    "
                                                >
                                                    <div class="mb-2 p-0">
                                                        <div class="form-group">
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                maxlength="50"
                                                                placeholder="Other"
                                                                v-model="
                                                                    form.type_of_company_other
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Company name -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label"
                                            >Date of Incorporation <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="date_of_incorporation"
                                            placeholder="Date of Incorporation"
                                            v-model="form.date_of_incorporation"
                                            @change="calculateYearInOperation"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.date_of_incorporation,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.date_of_incorporation }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Company Reg No -->
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label
                                            for="validationCustom02"
                                            class="form-label"
                                            >No. of year in Operation</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="No. of year in Operation"
                                            v-model="form.year_in_operation"
                                        />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom02" class="form-label">
                                            SST Registration No. 
                                        </label>
                                        <div class="row">
                                            <div class="col-sm-6 mb-2">
                                                <input
                                                    type="text"
                                                    id="validationCustom02"
                                                    class="form-control"
                                                    maxlength="20"
                                                    placeholder="SST Registration No."
                                                    v-model="form.sst_registration_no"
                                                    v-bind:class="{ 'is-invalid': errors.sst_registration_no }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errors.sst_registration_no }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom02"
                                        >
                                            Vendor Type <span style="color:red">*</span></label
                                        >
                                        <select
                                            class="form-select"
                                            v-model="
                                                form.vendor_type
                                            "
                                            v-bind:class="{
                                                'is-invalid': errors.vendor_type,
                                            }"
                                        >
                                            <option disabled value="">Select</option>
                                            <option value="Local">
                                                Local
                                            </option>
                                            <option value="Foreign">
                                                Foreign
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            {{
                                                errors.vendor_type
                                            }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom02"
                                        >
                                            Account Type <span style="color:red">*</span></label
                                        >
                                        <select
                                            class="form-select"
                                            v-model="
                                                form.account_type
                                            "
                                            v-bind:class="{
                                                'is-invalid': errors.account_type,
                                            }"
                                        >
                                            <option disabled value=null>Select</option>
                                            <option value="Company">
                                                Company
                                            </option>
                                            <option value="Individual">
                                                Individual
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            {{
                                                errors.account_type
                                            }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group mb-3 position-relative">
                                        <label class="form-label" for="validationCustom02">MSIC Code <span style="color:red">*</span></label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Search MSIC code"
                                            :value="displayValue"
                                            @input="searchQuery = $event.target.value; form.msic_code = null"
                                            @focus="dropdownOpen = true"
                                            @blur="closeDropdown"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.msic_code,
                                            }"
                                        >

                                        <span
                                            v-if="form.msic_code || searchQuery"
                                            class="position-absolute end-0 translate-middle-y me-2 text-danger"
                                            style="cursor: pointer; top: 70%;"
                                            @mousedown.prevent="clearSelection"
                                        >
                                            &times;
                                        </span>

                                        <ul
                                            v-if="dropdownOpen && filteredMsic.length"
                                            class="list-group position-absolute w-100"
                                            style="z-index: 1000; max-height: 200px; overflow-y: auto;"
                                        >
                                            <li
                                                v-for="msic in filteredMsic"
                                                :key="msic.code"
                                                class="list-group-item list-group-item-action"
                                                @mousedown.prevent="selectMsic(msic)"
                                            >
                                                {{ msic.code }} - {{ msic.description }}
                                            </li>
                                        </ul>

                                        <div class="invalid-feedback">
                                            {{
                                                errors.msic_code
                                            }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label
                                            class="form-label"
                                            for="validationCustom02"
                                        >
                                            ID Type <span style="color:red">*</span></label
                                        >
                                        <select
                                            class="form-select"
                                            v-model="form.id_type"
                                            v-bind:class="{
                                                'is-invalid': errors.id_type,
                                            }"
                                        >
                                            <option value="">Select</option>
                                            <option value="NRIC">
                                                NRIC
                                            </option>
                                            <option value="PASSPORT">
                                                PASSPORT
                                            </option>
                                            <option value="BRN">
                                                BRN
                                            </option>
                                            <option value="ARMY">
                                                ARMY
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            {{
                                                errors.id_type
                                            }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                                <div class="form-group mb-3">
                                                <label class="form-label" for="validationCustom02">
                                                    ID Value.  <span style="color:red">*</span></label
                                                >
                                                    <input type="text" class="form-control" maxlength="20"
                                                        placeholder="ID Value" v-model="form.id_value"  :disabled="showAll && !editable" v-bind:class="{
                                                            'is-invalid':
                                                                errors.id_value,
                                                        }" />
                                                    <div class="invalid-feedback">
                                                        {{ errors.id_value }}
                                                    </div>
                                                </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="validationCustom02">
                                            Company TIN No.  <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="50"
                                            placeholder="Company TIN no."
                                            v-model="
                                                form.tin
                                            "
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.tin,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{
                                                errors.tin
                                            }}
                                        </div>
                                    </div>
                                </div>

                                <!-- contact person -->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label
                                                    for="validationCustom01"
                                                    class="form-label"
                                                    >Contact Person 1 <span style="color:red">*</span></label
                                                >
                                                <input
                                                    type="text"
                                                    placeholder="Contact Person"
                                                    class="form-control mb-1"
                                                    maxlength="30"
                                                    v-model="
                                                        form.contact_person_one
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.contact_person_one,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{
                                                        errors.contact_person_one
                                                    }}
                                                </div>
                                                <input
                                                    type="text"
                                                    placeholder="Designation"
                                                    class="form-control"
                                                    maxlength="30"
                                                    v-model="
                                                        form.designation_one
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.designation_one,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errors.designation_one }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label
                                                    for="validationCustom01"
                                                    class="form-label"
                                                    >Contact Person 2 </label
                                                >
                                                <input
                                                    type="text"
                                                    placeholder="Contact Person"
                                                    class="form-control mb-1"
                                                    maxlength="30"
                                                    v-model="
                                                        form.contact_person_two
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.contact_person_two,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{
                                                        errors.contact_person_two
                                                    }}
                                                </div>
                                                <input
                                                    type="text"
                                                    placeholder="Designation"
                                                    class="form-control"
                                                    maxlength="30"
                                                    v-model="
                                                        form.designation_two
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.designation_two,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{ errors.designation_two }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label
                                                    for="validationCustom01"
                                                    class="form-label"
                                                    >Contact Person 3 </label
                                                >
                                                <input
                                                    type="text"
                                                    placeholder="Contact Person"
                                                    class="form-control mb-1"
                                                    maxlength="30"
                                                    v-model="
                                                        form.contact_person_three
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.contact_person_three,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{
                                                        errors.contact_person_three
                                                    }}
                                                </div>
                                                <input
                                                    type="text"
                                                    placeholder="Designation"
                                                    class="form-control"
                                                    maxlength="30"
                                                    v-model="
                                                        form.designation_three
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.designation_three,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    {{
                                                        errors.designation_three
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Note -->
                                <div class="col-12"></div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <p class="text-secondary">
                                                <strong>*Note:</strong>
                                                Please attach your company
                                                profile (Including Certified
                                                true copy of Form 9, 24, 49 /
                                                SSM Certified)
                                            </p>
                                            <p
                                                class="text-muted font-italic mb-1"
                                            >
                                                Acceptable file type: jpg, jpeg,
                                                png, doc, docx, pdf, xls, xlsx.
                                                Max. file size: 10MBs
                                            </p>
                                            <p
                                                class="text-muted font-italic mb-1"
                                            >
                                                Can add up to 3 files.
                                            </p>
                                            <div class="w-100 add-more-file">
                                                <div id="profile">
                                                    <div
                                                        class="form-group mb-1"
                                                    >
                                                        <input
                                                            type="file"
                                                            class="form-control"
                                                            name="profile[]"
                                                            multiple="multiple"
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="text-danger small show mb-2"
                                                >
                                                    {{ errors.profile }}
                                                </div>
                                                <a
                                                    @click="
                                                        addMoreFile('profile')
                                                    "
                                                    class="link mb-2 d-inline-block crsr-p"
                                                    ><i
                                                        class="uil uil-plus"
                                                    ></i>
                                                    Add More File</a
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section B -->
                            <div class="w-100 p-2 bg-light p-2 mb-3">
                                <h5 class="m-0">B. Banking Information</h5>
                            </div>

                            <div class="row px-2">
                                <!-- Bank Name -->
                                <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="bank_name" class="form-label">
                                    Bank Name <span style="color:red">*</span>
                                    </label>
                                    <input
                                    id="bank_name"
                                    type="text"
                                    class="form-control"
                                    maxlength="50"
                                    placeholder="Bank Name"
                                    v-model="form.bank_name"
                                    :disabled="showAll && !editable"
                                    v-bind:class="{ 'is-invalid': errors.bank_name }"
                                    />
                                    <div class="invalid-feedback">
                                    {{ errors.bank_name }}
                                    </div>
                                </div>
                                </div>

                                <!-- Swift Code -->
                                <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="swift_code" class="form-label">
                                    Swift Code 
                                    </label>
                                    <input
                                    id="swift_code"
                                    type="text"
                                    class="form-control"
                                    maxlength="20"
                                    placeholder="Swift Code"
                                    v-model="form.swift_code"
                                    :disabled="showAll && !editable"
                                    v-bind:class="{ 'is-invalid': errors.swift_code }"
                                    />
                                    <div class="invalid-feedback">
                                    {{ errors.swift_code }}
                                    </div>
                                </div>
                                </div>

                                <!-- Bank Branch -->
                                <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="bank_branch" class="form-label">
                                    Bank Branch 
                                    </label>
                                    <input
                                    id="bank_branch"
                                    type="text"
                                    class="form-control"
                                    maxlength="20"
                                    placeholder="Bank Branch"
                                    v-model="form.bank_branch"
                                    :disabled="showAll && !editable"
                                    v-bind:class="{ 'is-invalid': errors.bank_branch }"
                                    />
                                    <div class="invalid-feedback">
                                    {{ errors.bank_branch }}
                                    </div>
                                </div>
                                </div>

                                <!-- Bank Account No -->
                                <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="bank_account_no" class="form-label">
                                    Bank Account No <span style="color:red">*</span>
                                    </label>
                                    <input
                                    id="bank_account_no"
                                    type="text"
                                    class="form-control"
                                    maxlength="30"
                                    placeholder="Bank Account No"
                                    v-model="form.bank_account_no"
                                    :disabled="showAll && !editable"
                                    v-bind:class="{ 'is-invalid': errors.bank_account_no }"
                                    />
                                    <div class="invalid-feedback">
                                    {{ errors.bank_account_no }}
                                    </div>
                                </div>
                                </div>

                                <!-- Bank Address 1 -->
                                <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="bank_address_one" class="form-label">Bank Address 1</label>
                                    <input
                                    id="bank_address_one"
                                    type="text"
                                    class="form-control"
                                    maxlength="50"
                                    placeholder="Bank Address 1"
                                    v-model="form.bank_address_one"
                                    :disabled="showAll && !editable"
                                    v-bind:class="{ 'is-invalid': errors.bank_address_one }"
                                    />
                                    <div class="invalid-feedback">
                                    {{ errors.bank_address_one }}
                                    </div>
                                </div>
                                </div>

                                <!-- Bank Address 2 -->
                                <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="bank_address_two" class="form-label">Bank Address 2</label>
                                    <input
                                    id="bank_address_two"
                                    type="text"
                                    class="form-control"
                                    maxlength="50"
                                    placeholder="Bank Address 2"
                                    v-model="form.bank_address_two"
                                    :disabled="showAll && !editable"
                                    v-bind:class="{ 'is-invalid': errors.bank_address_two }"
                                    />
                                    <div class="invalid-feedback">
                                    {{ errors.bank_address_two }}
                                    </div>
                                </div>
                                </div>

                                <!-- Bank Statement -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group mb-3 add-more-file">
                                        <label class="form-label">
                                            Bank Statement <span style="color:red">*</span>
                                        </label>
                                        <div id="bank_statements">
                                            <div class="form-group mb-1">
                                                <input
                                                    type="file"
                                                    class="form-control"
                                                    name="bank_statements[]"
                                                    multiple="multiple"
                                                />
                                            </div>
                                        </div>
                                        <div class="text-danger small show">
                                            {{ errors.bank_statements }}
                                        </div>
                                        <a
                                            @click="
                                                addMoreFile('bank_statements')
                                            "
                                            class="d-inline-block"
                                            ><i class="uil uil-plus"></i> Add
                                            More File</a
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Section C -->
                            <div class="w-100 p-2 bg-light p-2 mb-3">
                                <h5 class="m-0">C. Financial Information</h5>
                            </div>
                            <div class="row px-2">
                                <!-- Annual Turnover -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label
                                            for="annualturnover"
                                            class="form-label"
                                            >Annual Turnover (RM) <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Annual Turnover"
                                            v-model="form.annual_turnover"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.annual_turnover,
                                            }"
                                            @keypress="
                                                onKeypress(
                                                    $event,
                                                    form.annual_turnover
                                                )
                                            "
                                            @input="
                                                formatAsCurrency(
                                                    'annual_turnover'
                                                )
                                            "
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.annual_turnover }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Working Capital -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label
                                            for="workingcapital"
                                            class="form-label"
                                            >Working Capital (RM) <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Working Capital"
                                            v-model="form.working_capital"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.working_capital,
                                            }"
                                            @keypress="
                                                onKeypressAcceptNegativeNum(
                                                    $event,
                                                    form.working_capital
                                                )
                                            "
                                            @input="
                                                formatAsCurrency(
                                                    'working_capital'
                                                )
                                            "
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.working_capital }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Net worth -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label
                                            for="annualturnover"
                                            class="form-label"
                                            >Net Worth (RM) <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Net Worth"
                                            v-model="form.net_worth"
                                            v-bind:class="{
                                                'is-invalid': errors.net_worth,
                                            }"
                                            @keypress="
                                                onKeypressAcceptNegativeNum(
                                                    $event,
                                                    form.net_worth
                                                )
                                            "
                                            @input="
                                                formatAsCurrency('net_worth')
                                            "
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.net_worth }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Cash and Bank balance -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label
                                            for="annualturnover"
                                            class="form-label"
                                            >Cash And Bank Balance (RM) <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Cash and Bank Balance"
                                            v-model="form.cash_bank_balance"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.cash_bank_balance,
                                            }"
                                            @keypress="
                                                onKeypress(
                                                    $event,
                                                    form.cash_bank_balance
                                                )
                                            "
                                            @input="
                                                formatAsCurrency(
                                                    'cash_bank_balance'
                                                )
                                            "
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.cash_bank_balance }}
                                        </div>
                                    </div>
                                </div>
                                <!-- paid up Capital -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label
                                            for="annualturnover"
                                            class="form-label"
                                            >Paid Up Capital (RM) <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Paid Up Capital"
                                            v-model="form.paid_up_capital"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.paid_up_capital,
                                            }"
                                            @keypress="
                                                onKeypress(
                                                    $event,
                                                    form.paid_up_capital
                                                )
                                            "
                                            @input="
                                                formatAsCurrency(
                                                    'paid_up_capital'
                                                )
                                            "
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.paid_up_capital }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Note -->
                                <div class="col-12">
                                    <p class="text-secondary">
                                        <strong>*Note:</strong>
                                    </p>
                                    <p class="text-secondary mb-1">
                                        <span
                                            style="
                                                display: inline-block;
                                                width: 20px;
                                            "
                                            >*</span
                                        >Average of last 3 years figures base on
                                        Audited Financial Statement
                                    </p>
                                    <p class="text-secondary mb-1">
                                        <span
                                            style="
                                                display: inline-block;
                                                width: 20px;
                                            "
                                            >**</span
                                        >
                                        Base on latest month end balance. Only
                                        applicable for Purchase Order amount
                                        above RM1 million.
                                    </p>
                                    <p class="text-secondary mb-1">
                                        <span
                                            style="
                                                display: inline-block;
                                                width: 20px;
                                            "
                                            >i.</span
                                        >
                                        Working Capital = Total Current Assets -
                                        Total Current Liabilities
                                    </p>
                                    <p class="text-secondary mb-1">
                                        <span
                                            style="
                                                display: inline-block;
                                                width: 20px;
                                            "
                                            >ii.</span
                                        >Net Worth = Total Assets - Total
                                        Liabilities
                                    </p>
                                </div>
                            </div>
                            <!-- Section C -->
                            <div class="w-100 p-2 bg-light p-2 mb-3">
                                <h5 class="m-0">D. Product Description</h5>
                            </div>
                            <div class="row px-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">1.</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="50"
                                            v-model="form.product_desc_one"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.product_desc_one,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.product_desc_one }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">2.</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="50"
                                            v-model="form.product_desc_two"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">3.</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="50"
                                            v-model="form.product_desc_three"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">4.</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="50"
                                            v-model="form.product_desc_four"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">5.</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="50"
                                            v-model="form.product_desc_five"
                                        />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">6.</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="50"
                                            v-model="form.product_desc_six"
                                        />
                                    </div>
                                </div>
                                <!-- Note -->
                                <div class="col-12">
                                    <p class="text-secondary">
                                        <strong>*Note:</strong>
                                    </p>
                                    <p class="text-secondary mb-1">
                                        1. Please attach Product Catalogues /
                                        Brochures / Specification (if any) and
                                        complete the Referral Projects in
                                        Appendix A.
                                        <b
                                            >Click here to
                                            <a
                                                href="/storage/Referral_Projects.xlsx"
                                                target="_blank"
                                            >
                                                download Referral Projects
                                                template
                                            </a></b
                                        >
                                    </p>
                                    <div class="col-12 col-sm-4 add-more-file">
                                        <div id="product_catalogue">
                                            <div class="form-group mb-1">
                                                <input
                                                    type="file"
                                                    class="form-control"
                                                    name="product_catalogue[]"
                                                    multiple="multiple"
                                                />
                                            </div>
                                        </div>
                                        <div class="text-danger small show">
                                            {{ errors.product_catalogue }}
                                        </div>
                                        <a
                                            @click="
                                                addMoreFile('product_catalogue')
                                            "
                                            class="d-inline-block mb-3"
                                            ><i class="uil uil-plus"></i> Add
                                            More File</a
                                        >
                                    </div>
                                    <p class="text-secondary mb-0">
                                        2. Please attach a copy of the latest
                                        product Certified for respective product
                                        (if any)
                                    </p>
                                    <div class="col-12">
                                        <div class="row">
                                            <div
                                                class="col-12 col-sm-6 col-md-4"
                                            >
                                                <p
                                                    class="text-muted font-italic mb-1"
                                                >
                                                    Acceptable file type: jpg,
                                                    jpeg, png, doc, docx, pdf,
                                                    xls, xlsx. Max. file size:
                                                    10MBs
                                                </p>
                                                <p
                                                    class="text-muted font-italic mb-1"
                                                >
                                                    Can add up to 3 files.
                                                </p>
                                                <div
                                                    class="w-100 add-more-file"
                                                >
                                                    <div id="products">
                                                        <div
                                                            class="form-group mb-1"
                                                        >
                                                            <input
                                                                type="file"
                                                                class="form-control"
                                                                name="products[]"
                                                                multiple="multiple"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="text-danger small show"
                                                    >
                                                        {{ errors.products }}
                                                    </div>
                                                    <a
                                                        @click="
                                                            addMoreFile(
                                                                'products'
                                                            )
                                                        "
                                                        class="d-inline-block mb-3 crsr-p"
                                                        ><i
                                                            class="uil uil-plus"
                                                        ></i>
                                                        Add More File</a
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Section D -->
                            <div class="w-100 p-2 bg-light p-2 mb-3">
                                <h5 class="m-0">E. Credit Term Offered</h5>
                            </div>
                            <div class="row px-2">
                                <div class="col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <select
                                            class="form-select"
                                            v-model="form.credit_term_offered"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.credit_term_offered,
                                            }"
                                            v-on:change="
                                                delete form.credit_term_offered_other
                                            "
                                        >
                                            <option :value="null">
                                                Select
                                            </option>
                                            <option value="30 days">
                                                30 Days
                                            </option>
                                            <option value="60 days">
                                                60 Days
                                            </option>
                                            <option value="90 days">
                                                90 Days
                                            </option>
                                            <option value="other">
                                                Other (Please Specify)
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ errors.credit_term_offered }}
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="col-sm-6 col-12"
                                    v-if="form.credit_term_offered === 'other'"
                                >
                                    <div class="form-group mb-3">
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="50"
                                            placeholder="Other"
                                            v-model="
                                                form.credit_term_offered_other
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                            <!-- Section E -->
                            <div class="w-100 p-2 bg-light p-2 mb-3">
                                <h5 class="m-0">F. Certification</h5>
                            </div>
                            <div class="row px-2">
                                <div class="col-sm-4 col-12">
                                    <div
                                        class="custom-control custom-checkbox mb-2"
                                    >
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="iso-9001"
                                            value="ISO 9001"
                                            v-model="certification"
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="iso-9001"
                                            >ISO 9001</label
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <div
                                        class="custom-control custom-checkbox mb-2"
                                    >
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="iso-14001"
                                            value="ISO-14001"
                                            v-model="certification"
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="iso-14001"
                                            >ISO 14001</label
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <div
                                        class="custom-control custom-checkbox mb-2"
                                    >
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="ohsas-18001-iso-45001"
                                            value="ISO 45001"
                                            v-model="certification"
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="ohsas-18001-iso-45001"
                                            >ISO 45001</label
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <div
                                        class="custom-control custom-checkbox mb-2"
                                    >
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="iso-37001"
                                            value="ISO 37001"
                                            v-model="certification"
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="iso-37001"
                                            >ISO 37001</label
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <div
                                        class="custom-control custom-checkbox mb-2"
                                    >
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="other-certification"
                                            value="other"
                                            v-model="certification"
                                            v-on:change="
                                                delete form.certification_other
                                            "
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="other-certification"
                                            >Other (Please Specify)</label
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <div
                                        class="form-group mb-3"
                                        v-if="certification.includes('other')"
                                    >
                                        <input
                                            type="text"
                                            class="form-control"
                                            maxlength="50"
                                            placeholder="Other (Please Specify)"
                                            v-model="form.certification_other"
                                        />
                                    </div>
                                </div>
                                <!-- Note -->
                                <div class="col-12"></div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <p class="text-secondary">
                                                <strong>*Note:</strong>
                                                Please attach a copy of the
                                                latest Certificate(s)
                                            </p>
                                            <p
                                                class="text-muted font-italic mb-1"
                                            >
                                                Acceptable file type: jpg, jpeg,
                                                png, doc, docx, pdf, xls, xlsx.
                                                Max. file size: 10MBs
                                            </p>
                                            <p
                                                class="text-muted font-italic mb-1"
                                            >
                                                Can add up to 3 files.
                                            </p>
                                            <div class="w-100 add-more-file">
                                                <div id="certificates">
                                                    <div
                                                        class="form-group mb-1"
                                                    >
                                                        <input
                                                            type="file"
                                                            class="form-control"
                                                            name="certificates[]"
                                                            multiple="multiple"
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="text-danger small mb-2 show"
                                                >
                                                    {{ errors.certificates }}
                                                </div>
                                                <a
                                                    @click="
                                                        addMoreFile(
                                                            'certificates'
                                                        )
                                                    "
                                                    class="d-inline-block mb-3 crsr-p"
                                                    ><i
                                                        class="uil uil-plus"
                                                    ></i>
                                                    Add More File</a
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Section F -->
                            <div class="w-100 p-2 bg-light p-2 mb-3">
                                <h5 class="m-0">G. Litigation Records</h5>
                            </div>
                            <div class="row px-2">
                                <!-- notes -->
                                <div class="col-12">
                                    <p class="text-secondary mb-1">
                                        Is/Was your company involved in any
                                        past, pending or potential litigation /
                                        arbitration
                                    </p>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-select"
                                                    v-model="
                                                        form.litigation_records
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.litigation_records,
                                                    }"
                                                    v-on:change="
                                                        delete form.litigation_records_other
                                                    "
                                                >
                                                    <option :value="null">
                                                        Select
                                                    </option>
                                                    <option value="1">
                                                        Yes (Please Specify)
                                                    </option>
                                                    <option value="0">
                                                        No
                                                    </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{
                                                        errors.litigation_records
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-12 col-sm-6"
                                            v-if="
                                                form.litigation_records === '1'
                                            "
                                        >
                                            <div class="form-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="50"
                                                    placeholder="Other"
                                                    v-model="
                                                        form.litigation_records_other
                                                    "
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Section G -->
                            <div class="w-100 p-2 bg-light p-2 mb-3">
                                <h5 class="m-0">
                                    H. Corruption/Fraudulent Records
                                </h5>
                            </div>
                            <div class="row px-2">
                                <!-- notes -->
                                <div class="col-12">
                                    <p class="text-secondary mb-1">
                                        Has any of your employees (Including
                                        Directors and top Management) committed
                                        any crime related to bribery, fraud,
                                        dishonesty or similar misconduct or have
                                        been investigated, convicted sanctioned,
                                        debarred for bribery or similar conduct?
                                    </p>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-select"
                                                    v-model="
                                                        form.corruption_fraudulent_records
                                                    "
                                                    v-bind:class="{
                                                        'is-invalid':
                                                            errors.corruption_fraudulent_records,
                                                    }"
                                                    v-on:change="
                                                        delete form.corruption_fraudulent_records_other
                                                    "
                                                >
                                                    <option :value="null">
                                                        Select
                                                    </option>
                                                    <option value="1">
                                                        Yes (Please Specify)
                                                    </option>
                                                    <option value="0">
                                                        No
                                                    </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{
                                                        errors.corruption_fraudulent_records
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-12 col-sm-6"
                                            v-if="
                                                form.corruption_fraudulent_records ===
                                                '1'
                                            "
                                        >
                                            <div class="form-group">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    maxlength="50"
                                                    placeholder="Other"
                                                    v-model="
                                                        form.corruption_fraudulent_records_other
                                                    "
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section H -->
                            <div class="w-100 p-2 bg-light p-2 mb-3">
                                <h5 class="m-0">
                                    I. Vendor Letter of Declaration
                                </h5>
                            </div>
                            <div class="row px-2">
                                <div class="col-12 col-sm-6">
                                    <a
                                        :href="vendor_letter_of_declaration_url"
                                        target="_blank"
                                        class="btn btn-primary mt-sm-3 mb-2"
                                    >
                                        Download Declaration
                                    </a>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group mb-1">
                                        <label class="form-label"
                                            >Upload Declaration</label
                                        >
                                        <input
                                            type="file"
                                            class="form-control"
                                            ref="declaration_by_supplier"
                                            v-on:change="
                                                handleFileUpload(
                                                    'declaration_by_supplier',
                                                    'declaration_by_supplier'
                                                )
                                            "
                                        />
                                        <div
                                            id="declaration_by_supplier"
                                            class="text-danger small mb-2 show"
                                        >
                                            {{ errors.declaration_by_supplier }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section I -->
                            <div class="w-100 p-2 bg-light p-2 mb-2">
                                <h5 class="m-0">
                                    J. Non-Disclosure Agreement
                                </h5>
                            </div>
                            <div class="row px-2">
                                <!-- notes -->
                                <div class="col-12">
                                    <p class="text-secondary mb-0">
                                       View to agree to the Non-Disclosure Agreement. 
                                    
                                       <template v-if="!form.view_non_disclosure_agreement || form.view_non_disclosure_agreement == ''">
                                            <em class="text-danger">Incomplete</em> 
                                       </template>
                                       <template v-else>
                                            <em class="text-success">Completed on {{formatDateAndTime(form.view_non_disclosure_agreement)}}</em>
                                       </template>
                                    </p>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <!-- view_non_disclosure_agreement: null,
                                        non_disclosure_agreement_url: null, -->
                                        <div class="col-12 col-sm-6">
                                            <template v-if="!non_disclosure_agreement_url">
                                                <a
                                                    role="button"
                                                    @click="openModal"
                                                    class="btn btn-primary mt-sm-2 mb-2"
                                                >
                                                    View Non-Disclosure Agreement
                                                </a>
                                            </template>

                                            <template v-else>
                                                <a
                                                    role="button"
                                                    @click="handleDisclosureClick"
                                                    class="btn btn-primary mt-sm-2 mb-2"
                                                >
                                                    View Non-Disclosure Agreement
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section J -->
                            <div class="w-100 p-2 bg-light p-2 mb-3">
                                <h5 class="m-0">
                                    K. Download Supplier Registration Form
                                </h5>
                            </div>
                            <div class="row px-2">
                                <!-- Note -->
                                <div class="col-12 mb-4">
                                    <p class="text-secondary">
                                        I / We hereby confirm that all
                                        particular given above (Item A to G) are
                                        true, accurate and up to date. Mudajaya
                                        Group Berhad or its relevant
                                        subsidiaries (MGB) will be updated
                                        promptly should there be any changes of
                                        such information. I / We hereby declare
                                        and affirm that I am authorized to make
                                        this declaration on my company's behalf.
                                    </p>
                                    <p class="text-secondary">
                                        I / We hereby agree to adhere strictly
                                        to MGB's Integrated Management Systems,
                                        Anti Bribery Management Systems, all
                                        relevant legal requirements and other
                                        requirements whichever applicable.
                                    </p>
                                    <p class="text-secondary">
                                        MGB shall reserve the absolute right
                                        approve or reject my / out application
                                        as MGB deems fit without assigning any
                                        reason.
                                    </p>
                                    <p class="text-secondary">
                                        The Understanding also UNDERTAKE to
                                        notify MGB soonest possible should be
                                        there be any litigation or arbitration
                                        is taken against the Company, and MGB
                                        upon receipt of the said notification
                                        reserve the right to terminate the
                                        registration if the Company's
                                        performance is determined to be affected
                                        by the said litigation or arbitration.
                                    </p>
                                </div>
                                <!-- Company director and stamp -->
                                <!-- <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <div class="form-group mb-0">
                                                <label
                                                    >Authorized Company
                                                    Directors</label
                                                >
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="w-100">
                                                <div class="form-group mb-0">
                                                    <label>Company Stamp</label>
                                                </div>
                                                <signature></signature>
                                            </div>
                                            <button
                                                type="button"
                                                class="btn btn-primary btn-small mb-1"
                                                @click="saveImage"
                                            >
                                                Save Image
                                            </button>
                                            <button
                                                class="btn btn-secondary btn-small mb-1"
                                                type="button"
                                                @click="resetCanvas"
                                            >
                                                Reset Canvas
                                            </button>
                                            <img
                                                ref="img"
                                                src=""
                                                id="canvas-image"
                                            />
                                        </div>
                                    </div>
                                </div> -->
                                <!-- Name -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Name <span style="color:red">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Name"
                                            v-model="form.name"
                                            maxlength="30"
                                            v-bind:class="{
                                                'is-invalid': errors.name,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Designation -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label"
                                            >Designation <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="text"
                                            placeholder="Designation"
                                            class="form-control"
                                            maxlength="30"
                                            v-model="form.designation"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.designation,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.designation }}
                                        </div>
                                    </div>
                                </div>
                                <!-- NRIC Number -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label"
                                            >NRIC Number <span style="color:red">*</span></label
                                        >
                                        <input
                                            type="text"
                                            placeholder="NRIC Number"
                                            maxlength="12"
                                            class="form-control"
                                            v-model="form.nric_no"
                                            v-bind:class="{
                                                'is-invalid': errors.nric_no,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.nric_no }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Date -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Date <span style="color:red">*</span></label>
                                        <input
                                            type="date"
                                            placeholder="Date"
                                            id="date"
                                            class="form-control"
                                            v-model="form.date"
                                            v-bind:class="{
                                                'is-invalid': errors.date,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            {{ errors.date }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-2">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group mb-1">
                                        <input
                                            style="display: none"
                                            type="file"
                                            class="form-control"
                                            ref="supplier_pdf"
                                            v-on:change="
                                                handleFileUpload(
                                                    'supplier_pdf',
                                                    'supplier_pdf'
                                                )
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                            <!-- form actions  -->
                            <div class="row px-2">
                                <div class="col-12 text-center mt-3 mb-3">
                                    <button
                                        class="btn btn-rounded save-draft mr-2 btn-lg"
                                        type="button"
                                        @click="printPdf('save')"
                                    >
                                        Save Draft
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <hr />
                                    <h5 class="heading-sm">INSTRUCTIONS</h5>
                                    <ul class="instruction-steps">
                                        <li class="active">
                                            <p class="step-heading">
                                                Step 1. Complete all the fields
                                                above. Once completed click
                                                download.
                                                <span
                                                    class="status incomplete"
                                                    v-if="is_downlaod === true"
                                                    >Complete</span
                                                ><span
                                                    class="status incomplete"
                                                    v-else="
                                                        is_downlaod === false
                                                    "
                                                    >Incomplete</span
                                                >
                                            </p>
                                            <div class="step-strip">
                                                <div class="text">
                                                    <p>
                                                        Download Supplier
                                                        Registration Form
                                                    </p>
                                                </div>
                                                <div class="action">
                                                    <button
                                                        class="btn"
                                                        type="button"
                                                        @click="
                                                            printPdf('submit')
                                                        "
                                                    >
                                                        Download
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                        <li
                                            id="upload-pdf"
                                            :class="
                                                upload_pdf === true
                                                    ? 'active'
                                                    : ''
                                            "
                                        >
                                            <p class="step-heading">
                                                Step 2. Upload the signed
                                                supplier registration form
                                                <span
                                                    class="status incomplete"
                                                    v-if="is_attach === true"
                                                    >Complete</span
                                                ><span
                                                    class="status incomplete"
                                                    v-else="is_attach === false"
                                                    >Incomplete</span
                                                >
                                            </p>
                                            <div class="step-strip">
                                                <div class="text">
                                                    <p>
                                                        Upload Signed Supplier
                                                        Registration Form
                                                    </p>
                                                </div>
                                                <div class="action">
                                                    {{
                                                        form.supplier_pdf
                                                            ? form.supplier_pdf
                                                                  .split("/")
                                                                  .pop()
                                                            : ""
                                                    }}
                                                    <button
                                                        v-if="
                                                            form.is_print === 1
                                                        "
                                                        type="button"
                                                        class="btn"
                                                        @click="
                                                            $refs.supplier_pdf.click()
                                                        "
                                                    >
                                                        Upload
                                                    </button>
                                                    <button
                                                        v-if="
                                                            form.is_print === 0
                                                        "
                                                        type="button"
                                                        class="btn"
                                                        @click="
                                                            $refs.supplier_pdf.click()
                                                        "
                                                        :disabled="isDisabled"
                                                    >
                                                        Upload
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                        <li
                                            id="complete-submission"
                                            :class="
                                                is_upload_pdf == true
                                                    ? 'active'
                                                    : ''
                                            "
                                        >
                                            <p class="step-heading">
                                                Step 3. Click complete.
                                                <span
                                                    class="status incomplete"
                                                    v-if="is_complete == true"
                                                    >Complete</span
                                                ><span
                                                    class="status incomplete"
                                                    v-else="
                                                        is_complete == false
                                                    "
                                                    >Incomplete</span
                                                >
                                            </p>
                                            <div class="step-strip">
                                                <div class="text">
                                                    <p>
                                                        Please Check Before
                                                        Submit
                                                    </p>
                                                </div>
                                                <div class="action">
                                                    <button
                                                        v-if="
                                                            form.is_print_upload ==
                                                                1 &&
                                                            form.is_print == 1
                                                        "
                                                        class="btn"
                                                        type="button"
                                                        @click="finalSubmission"
                                                    >
                                                        Complete and Submit
                                                    </button>
                                                    <button
                                                        v-else="
                                                            form.is_print_upload ==
                                                                0 &&
                                                            form.is_print == 0
                                                        "
                                                        class="btn"
                                                        type="button"
                                                        @click="finalSubmission"
                                                        :disabled="isUpload"
                                                    >
                                                        Complete and Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <template v-if="showUrl">
            <div class="modal-backdrop"></div>
            <div
                class="modal fade show d-block"
                tabindex="-1"
                :aria-hidden="false"
                :aria-modal="true"
                role="dialog"
                @click.self="showUrl = false"
            >
                <div
                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable m-auto"
                >
                    <div class="modal-content modal-body">
                        <div class="modal-body py-2 mx-auto">
                            Document not available. Please contact the system administrator if you believe this is an error.
                        </div>
                        <div
                            class="text-center py-2 gap-2 d-flex justify-content-center align-items-center"
                        >
                        <button class="btn btn-primary" @click.self="showUrl = false">Close</button>    
                    </div>
                    </div>
                </div></div
        ></template>
    </div>
    <div v-else-if="form.status === 1">
        <div class="account-pages mt-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card">
                            <div
                                class="card-header pt-4 pb-4 text-center bg-primary"
                            >
                                <a href="#">
                                    <span
                                        ><img
                                            :src="companyLogoUrl"
                                            alt="logo"
                                            width="100"
                                    /></span>
                                </a>
                            </div>
                            <div class="card-body p-4">
                                <center>
                                    <strong>Thank You!</strong>
                                    <p>We’ll notify you by email once your registration has been reviewed—whether it’s approved or needs further action.</p>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
@import "./Registration.css";

.custom-control-label {
    margin-left: 5px;
}

.crsr-p {
    cursor: pointer;
}

div.form-group {
    margin-bottom: 5px;
}
</style>
<script>
import Errors from "../commons/Errors.ts";
import Events from "../commons/Events.js";
import Config from "../commons/Config.ts";
import moment from "moment";
import axios from "axios";

export default {
    // components: {
    //     Signature,
    //     Loader,
    // },
    // props: {
    //     companyLogoUrl: {
    //         type: String,
    //         default: "",
    //     },
    // },
    data() {
        return {
            companyLogoUrl: "",
            is_verified: true,
            is_disable: false,
            is_upload: false,
            is_complete: false,
            is_downlaod: false,
            is_attach: false,
            upload_pdf: false,
            is_upload_pdf: false,
            uploaded_attachment: "",
            company_logo_url: "",
            base_url: "",
            file: "",
            certification: [],
            passcode_verification: {
                passcode: "",
            },
            showUrl: false,
            non_disclosure_agreement_url: null,
            vendor_letter_of_declaration_url: null,
            countries: [],
            states: [],
            msicCodes: [],
            searchQuery: '',
            dropdownOpen: false,
            form: {
                name_of_company: "",
                company_reg_no: "",
                registered_address_one: "",
                registered_address_two: "",
                vendor_type: "",
                account_type: "",
                msic_code: "",
                id_type: "",
                id_value: "",
                tin: "",
                city: "",
                state: "",
                zip_code: "",
                country: "",
                mailing_address_same_as_registered_address: false,
                mailing_address_one: "",
                mailing_address_two: "",
                mailing_address_city: "",
                mailing_address_state: "",
                mailing_address_country: "",
                mailing_address_zip_code: "",
                tel_no: "",
                fax_no: "",
                company_website: "",
                email_address: "",
                type_of_company: null,
                type_of_company_other: "",
                date_of_incorporation: null,
                year_in_operation: "",
                sst_registration_no: "",
                contact_person_one: "",
                designation_one: "",
                contact_person_two: "",
                designation_two: "",
                contact_person_three: "",
                designation_three: "",
                annual_turnover: "",
                working_capital: "",
                net_worth: "",
                cash_bank_balance: "",
                paid_up_capital: "",
                product_desc_one: "",
                product_desc_two: "",
                product_desc_three: "",
                product_desc_four: "",
                product_desc_five: "",
                product_desc_six: "",
                credit_term_offered: null,
                credit_term_offered_other: "",
                certification_other: "",
                litigation_records: null,
                litigation_records_other: "",
                corruption_fraudulent_records: null,
                corruption_fraudulent_records_other: "",
                declaration_by_supplier: "",
                supplier_pdf: "",
                name: "",
                designation: "",
                date: null,
                status: 0,
                view_non_disclosure_agreement: null,
                bank_name: "",
                swift_code: "",
                bank_branch: "",
                bank_account_no: "",
                bank_address_one: "",
                bank_address_two: "",
            },
            errors: {},
            backend_errors: {},
            loading: false,
        };
    },

    methods: {
        passcodeVerification(event, type) {
            event.preventDefault();
            let formData = new FormData();
            formData.append("unique_id", this.$route.params.unique_id);
            formData.append("passcode", this.passcode_verification.passcode);
            let condition = this.checkVerificationForm(type);
            if (condition) {
                this.$loadingStart();

                axios
                    .post("/api/passcode-verify", formData)
                    .then((res) => res.data)
                    .then((res) => {
                        this.is_verified = false;
                        sessionStorage.clear();
                        sessionStorage.setItem(this.$route.params.unique_id, "false");
                        this.$toast.success(res.message);
                    })
                    .catch((error) => {
                        error = error.response.data;
                        this.$toast.error(error.message);
                    })
                    .finally(() => this.$loadingStop());
            }
        },

        printPdf(type) {
            let condition = this.checkForm(type);
            this.form.certification = this.certification;

            // let formData = this.createFormData();
            // for (let pair of formData.entries()) {
            //     console.log(pair[0] + ": ", pair[1]);
            // }

            if (condition) {
                this.$loadingStart();
                axios
                    .post(`/api/registration?type=${type}`, this.createFormData())
                    .then((res) => res.data)
                    .then((res) => {
                        if (type != "save") {
                            let url = "/api/print-pdf/" + this.$route.params.unique_id;

                            // Fetch the PDF as a blob
                            axios
                                .get(url, { responseType: "blob" })
                                .then((response) => {
                                    let blob = new Blob([response.data], { type: "application/pdf" });

                                    // Format date as DDMMYYYY
                                    let today = new Date();
                                    let dd = String(today.getDate()).padStart(2, "0");
                                    let mm = String(today.getMonth() + 1).padStart(2, "0");
                                    let yyyy = today.getFullYear();
                                    let formattedDate = `${dd}${mm}${yyyy}`;

                                    // Create filename
                                    const currentTime = moment().format("HHmm");
                                    let filename = `Supplier Form - ${formattedDate}_${currentTime}.pdf`;

                                    // Create link and trigger download
                                    let link = document.createElement("a");
                                    link.href = window.URL.createObjectURL(blob);
                                    link.download = filename;
                                    document.body.appendChild(link);
                                    link.click();
                                    document.body.removeChild(link);

                                    this.is_disable = true;
                                    this.is_downlaod = true;
                                    document.getElementById("upload-pdf").classList.add("active");

                                    // let blob = new Blob([response.data], { type: "application/pdf" });
                                    // let blobUrl = window.URL.createObjectURL(blob);

                                    // window.open(blobUrl, "_blank");

                                    // this.is_disable = true;
                                    // this.is_downlaod = true;
                                    // document.getElementById("upload-pdf").classList.add("active");
                                });
                        }
                        this.$toast.success(res.message);
                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.backend_errors = error.response.data.errors || {};
                            for (let key in this.backend_errors) {
                                this.$toast.error(this.backend_errors[key][0]);
                            }
                        }
                    })
                    .finally(() => this.$loadingStop());
            }
        },
        finalSubmission() {
            let formData = new FormData();
            formData.append("unique_id", this.$route.params.unique_id);
            this.$loadingStart();

            axios
                .post("/api/final-submit", formData)
                .then((res) => res.data)
                .then((res) => {
                    if (res.success === true) {
                        this.form.status = 1;
                        this.is_complete = true;
                    }
                })
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => this.$loadingStop());
        },

        addMoreFile(id) {
            document.querySelector(`#${id}`).insertAdjacentHTML(
                "beforeend",
                `
            <div class="form-group mb-1" style="display: inline-flex;width: 410px;">
                    <input
                        type="file"
                        class="form-control"
                        name="${id}[]"
                        multiple="multiple"
                    />
                    <button type="button" class="remove-div btn btn-primary crsr-p">X</button>
                </div>
            `
            );
            var container = document.querySelector(`#${id}`);
            if (container.querySelectorAll("div").length === 3) {
                var parent = container.parentNode;
                var link = parent.querySelector("a");
                link.classList.remove("d-inline-block");
                link.classList.add("d-none");
            }
            // if (document.querySelector(`#${id}`).find("div").length === 3) {
            //     document.querySelector(`#${id}`)
            //         .parent()
            //         .find("a")
            //         .removeClass("d-inline-block")
            //         .addClass("d-none");
            //     return;
            // }
        },

        removeFileUpload(self) {
            // const target = $(self).parents(".add-more-file").find("a");
            // $(self).parent().remove();
            // target.addClass("d-inline-block").removeClass("d-none");

            const parent = self.closest(".add-more-file");
            const target = parent.querySelector("a");
            const parentElement = self.parentNode;
            parentElement.parentNode.removeChild(parentElement);
            target.classList.remove("d-none");
            target.classList.add("d-inline-block");
        },

        handleFileUpload(formField, refField) {
            if (refField != "supplier_pdf") {
                this.form[formField] = this.$refs[refField].files[0];
                document.getElementById(refField).classList.add("d-none");
            } else {
                let formData = new FormData();
                const input = this.$refs[refField].files[0];
                const inputSize = Math.round(input / 1024);
                if (input && inputSize > 10240) {
                    //this.errors['supplier_pdf'] = "File size must not be larger than 10MB";
                }
                if (input.type != "application/pdf") {
                    //this.errors['supplier_pdf'] = "Invalidss file extension specified";
                }
                if (input.type == "application/pdf") {
                    formData.append("file", input);
                    formData.append("unique_id", this.$route.params.unique_id);
                    axios
                        .post("/api/upload-pdf", formData, {
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                        })
                        .then((res) => res.data)
                        .then((res) => {
                            if (res.success === true) {
                                this.is_upload = true;
                                this.is_attach = true;
                                this.form.supplier_pdf = res.data.supplier_pdf;
                                document
                                    .getElementById("complete-submission")
                                    .classList.add("active");
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }
        },

        updateDisclosureAgreement() {
            this.$loadingStart();
            axios.put(`/api/update-disclosure-agreement?unique_id=${this.$route.params.unique_id}`)
            .then((res) => {
                const ts = res.data.data; // e.g. 2025-08-16T08:32:21.430868Z
                // trim microseconds to 3 digits so moment parses reliably
                const isoUtc = ts.replace(/\.(\d{3})\d+Z$/, '.$1Z');

                // add +8 hours and format like your formatter expects
                const localDbStyle = moment.parseZone(isoUtc)
                    .add(8, 'hours')
                    .format('YYYY-MM-DD HH:mm:ss');

                this.form.view_non_disclosure_agreement = localDbStyle;

                this.$toast.success(res.data.message);
            })
            .catch(() => this.$toast.error('Something went wrong'))
            .finally(() => this.$loadingStop());
        },

        getSupplierDetails() {
            this.$loadingStart();
            axios
                .get("/api/get-supplier-details", {
                    params: {
                        unique_id: this.$route.params.unique_id,
                    },
                })
                .then((res) => res.data)
                .then((res) => {
                    this.getOrganizationLogo(res.data.organization_id);
                    this.form = {
                        ...this.form,
                        ...res.data,
                    };

                    this.form.mailing_address_same_as_registered_address = res.data.mailing_address_same_as_registered_address === 1 ? true : false;

                    this.certification = this.form.certification
                        ? this.form.certification.split(",")
                        : [];
                    if (res.data.status != 1) {
                        this.$toast.success(res.message);
                    }
                    if (res.data.is_print === 1) {
                        this.upload_pdf = true;
                        this.is_downlaod = true;
                    }
                    if (
                        res.data.is_print === 1 &&
                        res.data.is_print_upload === 1
                    ) {
                        this.is_upload_pdf = true;
                        this.is_attach = true;
                    }

                    let decValues = [
                        "annual_turnover",
                        "working_capital",
                        "net_worth",
                        "cash_bank_balance",
                        "paid_up_capital",
                    ];
                    decValues.forEach((d) => {
                        let formattedValue = +this.form[d];
                        formattedValue = formattedValue.toLocaleString("en-US");
                        this.form[d] = formattedValue;
                    });
                })
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => this.$loadingStop());
        },

        getCountries() {
            axios.get('/api/countries-list')
                .then((res) => {
                    this.countries = res.data?.data || [];
                })
                .catch((err) => {
                    console.error(err);
                })
        },

        getStates() {
            axios.get('/api/state-list')
                .then((res) => {
                    this.states = res.data?.data || [];
                })
                .catch((err) => {
                    console.error(err);
                })
        },
            
        getMsicCodes() {
            axios.get('/api/msic-list')
                .then((res) => {
                    this.msicCodes = res.data?.data || [];
                })
                .catch((err) => {
                    console.error(err);
                })
        },

        checkVerificationForm(type) {
            this.errors = {};
            if (type == "verification") {
                let errorMessages = Errors.verification_screen;
                Object.keys(errorMessages).forEach((data) => {
                    if (!this.passcode_verification[data]) {
                        this.errors[data] = errorMessages[data];
                    }
                });
            }

            if (
                Object.keys(this.errors).length === 0 &&
                this.errors.constructor === Object
            ) {
                return true;
            }
        },

        checkForm(type) {
            this.errors = {};

            if (type === "save") {
                if (!this.form.name_of_company) {
                    this.errors.name_of_company = "Name of Company is required";
                }
                if (!this.form.company_reg_no) {
                    this.errors.company_reg_no = "Company Reg. No. is required";
                }

                if (Object.keys(this.errors).length) {
                    console.log("Form Errors (Save):", this.errors);
                    let errorKey = Object.keys(this.errors)[0]
                        .split("_")
                        .join(" ");
                    this.$toast.error(
                        errorKey.charAt(0).toUpperCase() +
                            errorKey.slice(1) +
                            " - " +
                            this.errors[Object.keys(this.errors)[0]]
                    );
                    return false;
                }
            }

            if (type !== "save") {
                let errorMessages = Errors.registration2;
                Object.keys(errorMessages).forEach((data) => {
                    if (!this.form[data]) {
                        this.errors[data] = errorMessages[data];
                    }
                });

                if (this.form.vendor_type === "Local" && !this.form.tin) {
                    this.errors.tin = "Company TIN No is required when Vendor Type is Local";
                }

                let decValues = [
                    "annual_turnover",
                    "working_capital",
                    "net_worth",
                    "cash_bank_balance",
                    "paid_up_capital",
                ];
                decValues.forEach((d) => {
                    let val = this.form[d];
                    val = val.replace(/,/g, "");
                    val = parseFloat(val);
                    if (!new RegExp("^[-+]?[1-9]\\d*(\\.\\d+)?$").test(val)) {
                        this.errors[d] = "Invalid value specified";
                    }
                });

                // this.checkFileValidation("certificates", "multi");
                this.checkFileValidation("profile", "multi");
                // this.checkFileValidation("products", "multi");
                // this.checkFileValidation("product_catalogue", "multi");
                this.checkFileValidation("bank_statements", "multi");
                this.checkFileValidation("declaration_by_supplier", "single");
                this.checkFileValidation("supplier_pdf", "single");
                let filesErr = [
                //    "products",
                    "certificates",
                    "profile",
                    "product_catalogue",
                    "declaration_by_supplier",
                    "bank_statements"
                ];
                // let errorKeys = Object.keys(this.errors);
                // let filesErrValue = errorKeys.filter(r => filesErr.includes(r));

                if (Object.keys(this.errors).length) {
                    // console.log("Form Errors:", this.errors);
                    let errorKey = Object.keys(this.errors)[0]
                        .split("_")
                        .join(" ");
                    this.$toast.error(
                        errorKey.charAt(0).toUpperCase() +
                            errorKey.slice(1) +
                            " - " +
                            this.errors[Object.keys(this.errors)[0]]
                    );
                    this.$toast.error(
                        'Do not leave any fields blank, please insert "-" if it is not applicable'
                    );
                    return false;
                }
            }

            if (
                Object.keys(this.errors).length === 0 &&
                this.errors.constructor === Object
            ) {
                return true;
            }
        },

        checkFileValidation(param, type) {
            if (type === "multi") {
                document.querySelectorAll(`input[name='${param}[]'`).forEach(
                    function (data) {
                        this.fileValidator(data, param);
                    }.bind(this)
                );
            } else {
                this.fileValidator(this.$refs[param], param);
            }
        },

        fileValidator(data, param) {
            const input = data.files[0];
            const inputSize = Math.round(input / 1024);
            if (param != "supplier_pdf") {
                if (!input) this.errors[param] = "File is required";
                if (input && inputSize > 10240)
                    this.errors[param] =
                        "File size must not be larger than 10MB";
                if (
                    input &&
                    !new RegExp(
                        "^.*\.(jpg|jpeg|png|pdf|doc|docx|xls|xlsx)$"
                    ).test(input.name)
                )
                    this.errors[param] = "Invalid file extension specified";
            }
        },

        createFormData() {
            let formData = new FormData();
            for (var key in this.form) {
                if (this.form[key]) formData.append(key, this.form[key]);
            }

            let decValues = [
                "annual_turnover",
                "working_capital",
                "net_worth",
                "cash_bank_balance",
                "paid_up_capital",
            ];
            decValues.forEach((d) => {
                let val = this.form[d];
                val = val.replace(/,/g, "");
                val = parseFloat(val);
                if (this.form[d]) formData.set(d, val);
            });

            document.querySelectorAll("input[name='certificates[]']").forEach(
                function (data, i) {
                    this.certificateVal = data.files[0];
                    if (data.files[0]) {
                        formData.append("certificates_" + i, data.files[0]);
                    }
                }.bind(this)
            );

            document.querySelectorAll("input[name='profile[]']").forEach(
                function (data, i) {
                    if (data.files[0]) {
                        formData.append("profile_" + i, data.files[0]);
                    }
                }.bind(this)
            );

            document.querySelectorAll("input[name='products[]']").forEach(
                function (data, i) {
                    if (data.files[0]) {
                        formData.append("products_" + i, data.files[0]);
                    }
                }.bind(this)
            );

            document
                .querySelectorAll("input[name='product_catalogue[]']")
                .forEach(
                    function (data, i) {
                        if (data.files[0]) {
                            formData.append(
                                "product_catalogue_" + i,
                                data.files[0]
                            );
                        }
                    }.bind(this)
                );

            document
                .querySelectorAll("input[name='bank_statements[]']")
                .forEach(
                    function (data, i) {
                        if (data.files[0]) {
                            formData.append(
                                "bank_statement_" + i,
                                data.files[0]
                            );
                        }
                    }.bind(this)
                );
            return formData;
        },

        onKeypress(e, data) {
            Events.onKeypress(e, data);
        },

        onKeypressAcceptNegativeNum(e, data) {
            Events.onKeypressAcceptNegativeNum(e, data);
        },

        calculateYearInOperation() {
            let date = moment(new Date(this.form.date_of_incorporation));
            let currentDate = moment();
            this.form.year_in_operation = currentDate
                .diff(date, "years", true)
                .toFixed(2);
        },

        initDatepicker() {
            let dateFields = ["date", "date_of_incorporation"];
            // dateFields.forEach((data) => {
            //     $("#date").datepicker({
            //         startDate: new Date(),
            //     });
            //     $(`#${data}`)
            //         .datepicker(
            //             "setDate",
            //             (this.form[data] = this.form[data]
            //                 ? new Date(this.form[data])
            //                 : new Date().toDateString())
            //         )
            //         .on("changeDate", () => {
            //             this.form[data] = $(`#${data}`).val();
            //             if (data === "date_of_incorporation") {
            //                 let date = moment(new Date(this.form[data]));
            //                 let currentDate = moment();
            //                 this.form.year_in_operation = currentDate
            //                     .diff(date, "years", true)
            //                     .toFixed(2);
            //             }
            //         });
            // });
        },

        // getCompanyLogoURL() {
        //     axios
        //         .get("/api/get-logo")
        //         .then((res) => res.data)
        //         .then((res) => {
        //             this.companyLogoUrl = res.data.logo;
        //         })
        //         .catch((error) => {
        //             error = error.response.data;
        //         });
        // },

        getOrganizationLogo(organizationId) {
            this.$loadingStart();
            axios
                .get("/api/get-organization-logo/" + organizationId)
                .then((res) => res.data)
                .then((res) => {
                    this.companyLogoUrl = res.data.logo_url;
                    this.non_disclosure_agreement_url = res.data.non_disclosure_agreement_url || null;
                    this.vendor_letter_of_declaration_url = res.data.vendor_letter_of_declaration_url || null;
                })
                .catch((error) => {
                    error = error.response.data;
                })
                .finally(() => this.$loadingStop());
        },

        formatAsCurrency(name) {
            if (this.form[name].indexOf(".") > -1) {
                return;
            }
            let formattedData = this.form[name];

            // Remove commas, but preserve decimal points
            formattedData = formattedData.replace(/,/g, "");

            // Parse the value as a float
            formattedData = parseFloat(formattedData);

            console.log(formattedData);

            // Check if the parsed value is NaN
            if (isNaN(formattedData)) return;

            // Format the value as currency
            formattedData = formattedData.toLocaleString("en-US");

            // Update the form data with the formatted value
            this.form[name] = formattedData;
        },

        openModal() {
            this.showUrl = true;
        },

        formatDateAndTime(dateStr) {
            return moment(dateStr, "YYYY-MM-DD HH:mm:ss").format("DD MMM YYYY, h:mm A");
        },

        handleDisclosureClick() {
            if (!this.form.view_non_disclosure_agreement) {
                this.updateDisclosureAgreement();
            }
            window.open(this.non_disclosure_agreement_url, '_blank');
        },
        selectMsic(msic) {
            this.form.msic_code = msic.code;
            this.searchQuery = `${msic.code} - ${msic.description}`;
            this.dropdownOpen = false;
        },
        closeDropdown() {
            setTimeout(() => this.dropdownOpen = false, 200);
        },
        clearSelection() {
            this.form.msic_code = null;
            this.searchQuery = '';
        },

        copyMailingAddress() {
            if (this.form.mailing_address_same_as_registered_address) {
            this.form.mailing_address_one = this.form.registered_address_one;
            this.form.mailing_address_two = this.form.registered_address_two;
            this.form.mailing_address_city = this.form.city;
            this.form.mailing_address_state = this.form.state;
            this.form.mailing_address_zip_code = this.form.zip_code;
            this.form.mailing_address_country = this.form.country;
            } 
        }
    },

    computed: {
        isDisabled: function () {
            return !this.is_disable;
        },
        isUpload: function () {
            return !this.is_upload;
        },
        filteredMsic() {
            if (!this.searchQuery) return this.msicCodes;
            const q = this.searchQuery.toLowerCase();
            return this.msicCodes.filter(msic =>
                msic.code.toLowerCase().includes(q) ||
                msic.description.toLowerCase().includes(q)
            );
        },
        displayValue() {
            if (this.form.msic_code) {
                const selected = this.msicCodes.find(m => m.code === this.form.msic_code);
                return selected ? `${selected.code} - ${selected.description}` : '';
            }
            return this.searchQuery;
        }
    },
    updated() {
        this.initDatepicker();
    },

    created() {
        const me = this;
        document.addEventListener("click", function (e) {
            if (e.target && e.target.matches(".remove-div, .remove-div *")) {
                me.removeFileUpload(e.target);
            }
        });
    },

        mounted() {
            // this.getCompanyLogoURL();
            this.getSupplierDetails();
            this.getCountries();
            this.getStates();
            this.getMsicCodes();

            const verified = sessionStorage.getItem(this.$route.params.unique_id);
            if(verified === "false") {
                this.is_verified = false;
            }

            // this.company_logo_url = Config.env.company_logo;
            this.base_url = Config.env.base_url;
        },
};
</script>
