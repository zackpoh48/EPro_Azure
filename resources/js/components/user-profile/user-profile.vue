<template>
    <div class="container">
        <div v-if="!isRegistering" class="page-title-box d-flex justify-content-between align-items-center py-2">
            <h4 class="header-title mb-0">Profile</h4>
            <button class="btn btn-primary" v-if="!editable" @click="editForm">Update Profile</button>
            <!-- <nav aria-label="breadcrumb ">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Manage</li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav> -->
        </div>

        <div class="card w-100" :class="{ 'mt-2 mt-sm-5': isRegistering }">
            <div class="card-header text-center bg-midnight p-0" v-if="isRegistering">
                <span><img :src="companyLogoUrl" alt="logo" height="100" /></span>
            </div>
            <!-- Registration -->
            <div class="card-body d-flex flex-column gap-2" :class="{ 'no-mouseevents': form.status === 4 && !editable }"
                v-if="form.status === 1 || form.status === 3 || form.status === 4">
                <form class="needs-validation" novalidate>
                    <!-- Form title -->
                    <div class="row" v-if="isRegistering">
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
                                <label for="validationCustom01">Name of Company <span v-if="isRegistering"
                                        class="require">*</span></label>
                                <input type="text" class="form-control" disabled maxlength="50"
                                    placeholder="Name of Company" v-model="form.company_name" v-bind:class="{
                                        'is-invalid': errors.company_name,
                                    }" />
                                <div class="invalid-feedback">
                                    {{ errors.company_name }}
                                </div>
                            </div>
                        </div>
                        <!-- Company Reg No -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="validationCustom02">Company Reg. No./NRIC No. <span v-if="isRegistering"
                                        class="require">*</span></label>
                                <input type="text" class="form-control" maxlength="20" disabled
                                    placeholder="Company Reg. No./NRIC No." v-model="form.company_reg_no" v-bind:class="{
                                        'is-invalid': errors.company_reg_no,
                                    }" />
                                <div class="invalid-feedback">
                                    {{ errors.company_reg_no }}
                                </div>
                            </div>
                        </div>
                        <template v-if="isRegistering || showAll">
                            <!-- Registered Address -->

                            <div class="w-100">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom02">
                                            SSM Address <span class="require">*</span></label>
                                        <input type="text" class="form-control" maxlength="50"
                                        :disabled="showAll && !editable"
                                            placeholder="Registered Address" v-model="form.registered_address_one"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.registered_address_one, 
                                            }" />
                                        <div class="invalid-feedback">
                                            {{ errors.registered_address_one }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <!--<label class="invisible" for="validationCustom02">
                                                Registered Address </label
                                            > -->
                                        <input type="text" class="form-control" maxlength="50"
                                            placeholder="Registered Address" v-model="form.registered_address_two"
                                            :disabled="showAll && !editable"
                                            v-bind:class="{
                                                'is-invalid':
                                                    errors.registered_address_two,
                                            }" />
                                        <div class="invalid-feedback">
                                            {{ errors.registered_address_two }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Mailing Address -->
                            <div class="w-100">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label for="validationCustom02" class="me-2">
                                            Mailing Address <span class="require">*</span></label>
                                            <input id="sameCheckbox" type="checkbox" class="me-1" @change="sameAddress($event)"><label for="sameCheckbox">
                                                 Same as SSM Address</label>
                                        <input type="text" class="form-control" maxlength="50" placeholder="Mailing Address"
                                            v-model="form.mailing_address_one" :disabled="showAll && !editable" v-bind:class="{
                                                'is-invalid':
                                                    errors.mailing_address_one,
                                            }" />
                                        <div class="invalid-feedback">
                                            {{ errors.mailing_address_one }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <!-- <label class="invisible" for="validationCustom02">
                                                Mailing Address </label
                                            >-->
                                        <input type="text" class="form-control" maxlength="50" placeholder="Mailing Address"
                                            v-model="form.mailing_address_two"   :disabled="showAll && !editable" v-bind:class="{
                                                'is-invalid':
                                                    errors.mailing_address_two,
                                            }" />
                                        <div class="invalid-feedback">
                                            {{ errors.mailing_address_two }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Zip  City Country -->
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Country</label>
                                            <select class="form-select" v-model="form.country"  @change="getState" :disabled="showAll && !editable" v-bind:class="{
                                                    'is-invalid': errors.country,
                                                }">
                                                <option value="" selected>--select--</option>
                                                <option v-for="country in countryList" :value="country.Code">{{ country.Country }}</option>
                                            </select>
                                            <!-- <input type="text" style="text-transform: uppercase" class="form-control"
                                                maxlength="10" placeholder="Country" v-model="form.country" v-bind:class="{
                                                    'is-invalid': errors.country,
                                                }" /> -->
                                                <div class="invalid-feedback">
                                                    {{ errors.country }}
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="form-group mb-3">
                                            <label>State</label>
                                            <select v-if="form.country && stateList.length"  class="form-select" v-model="form.state"  :disabled="showAll && !editable" v-bind:class="{
                                                    'is-invalid': errors.state,
                                                }">
                                                <option value="">--select--</option>
                                                <option v-for="state in stateList" :value="state.name">{{ state.name }}</option>
                                                
                                            </select>
                                            <input v-else type="text" class="form-control" maxlength="30" placeholder="State" :disabled="showAll && !editable"
                                                v-model="form.state" v-bind:class="{
                                                    'is-invalid': errors.state,
                                                }" />
                                            <div class="invalid-feedback">
                                                {{ errors.state }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="form-group mb-3">
                                            <label>City</label>
                                        
                                            <input type="text" class="form-control" maxlength="30" placeholder="City" :disabled="showAll && !editable"
                                                v-model="form.city" v-bind:class="{
                                                    'is-invalid': errors.city,
                                                }" />
                                            <div class="invalid-feedback">
                                                {{ errors.city }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Zip Code</label>
                                            
                                            <input type="text" class="form-control" maxlength="20" placeholder="Zip Code" :disabled="showAll && !editable"
                                                v-model="form.zip_code" v-bind:class="{
                                                    'is-invalid': errors.zip_code,
                                                }" />
                                            <div class="invalid-feedback">
                                                {{ errors.zip_code }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Telephone -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="validationCustom01">Telephone Number <span class="require">*</span></label>
                                    <input type="tel" class="form-control" maxlength="30" placeholder="Telephone Number"
                                        v-model="form.tel_no"  :disabled="showAll && !editable" @keypress="onKeypress($event, form.tel_no)" v-bind:class="{
                                            'is-invalid': errors.tel_no,
                                        }" />
                                    <div class="invalid-feedback">
                                        {{ errors.tel_no }}
                                    </div>
                                </div>
                            </div>
                            <!-- Fax -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="validationCustom02">Fax Number 
                                    </label>
                                    <input type="text" class="form-control" maxlength="30" placeholder="Fax Number"
                                        v-model="form.fax_no"  :disabled="showAll && !editable" v-bind:class="{
                                            'is-invalid': errors.fax_no,
                                        }" />
                                    <div class="invalid-feedback">
                                        {{ errors.fax_no }}
                                    </div>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="validationCustom02">Web Portal Username <span
                                            class="require">*</span></label>
                                    <input type="text" class="form-control" maxlength="80" 
                                        placeholder="Web Portal Username" v-model="form.username"  disabled v-bind:class="{
                                            'is-invalid': errors.username,
                                        }" />
                                    <div class="invalid-feedback">
                                        {{ errors.username }}
                                    </div>
                                </div>
                            </div>
                            <!--Registered Email  -->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="validationCustom02">Registered Email Address<span class="require">*</span></label>
                                    <input type="email" class="form-control" maxlength="80" placeholder="Email Address" disabled
                                        v-model="form.registered_email_address"  :disabled="showAll && !editable" v-bind:class="{
                                            'is-invalid': errors.registered_email_address,
                                        }" />
                                    <div class="invalid-feedback">
                                        {{ errors.registered_email_address }}
                                    </div>
                                </div>
                            </div>
                            <!-- Type of company -->
                            <div class="col-12">
                                <div class="form-group mb-1">
                                    <label class="d-block">Type of Company <span class="require">*</span></label>
                                    <div class="w-100">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group mb-3">
                                                    <select class="form-select" required  :disabled="showAll && !editable" v-model="form.type_of_company
                                                        " v-bind:class="{
        'is-invalid':
            errors.type_of_company,
    }" v-on:change="
    delete form.type_of_company_other
    ">
                                                        <option value="Sole Proprietor">
                                                            Sole Proprietor
                                                        </option>
                                                        <option value="Partnership">
                                                            Partnership
                                                        </option>
                                                        <option value="Private Limited">
                                                            Private Limited
                                                        </option>
                                                        <option value="Public Listed">
                                                            Public Listed
                                                        </option>
                                                        <option value="Others (Please Specify)">
                                                            Others (Please Specify)
                                                        </option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ errors.type_of_company }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-6" v-if="form.type_of_company ===
                                                'Others (Please Specify)'">
                                                <div class="mb-2 p-0">
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" maxlength="50" :disabled="showAll && !editable"
                                                            placeholder="Other" v-model="form.type_of_company_other" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-1">

                                    <label for="validationCustom01">Company Website</label>
                                    <div class="w-100">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group mb-3">
                                                    <input type="text" class="form-control" maxlength="80"
                                                        placeholder="Company Website" v-model="form.company_website"  :disabled="showAll && !editable"
                                                        v-bind:class="{
                                                            'is-invalid': errors.company_website,
                                                        }" />
                                                    <div class="invalid-feedback">
                                                        {{ errors.company_website }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Date of Incoperation-->
                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Date of Incorporation</label>
                                    <input type="date" id="inputDate" v-model="form.date_of_incorporation"
                                        :max="$date(new Date, 'YYYY-MM-DD')"
                                        style="width: 0; height: 0; outline: none; opacity: 0;" />
                                    <input type="text" class="form-control" :value="$date(form.date_of_incorporation)"  :disabled="showAll && !editable"
                                    disabled id="date_of_incorporation" @click="openDatePicker()"
                                        placeholder="Date of Incorporation" v-bind:class="{
                                            'is-invalid':
                                                errors.date_of_incorporation
                                        }" />
                                    <div class="invalid-feedback">
                                        {{ errors.date_of_incorporation }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="validationCustom02">SST Registration No. <span
                                            class="require">*</span></label>
                                    <input type="text" class="form-control" maxlength="20"
                                        placeholder="SST Registration No." v-model="form.sst_registration_no"  :disabled="showAll && !editable" v-bind:class="{
                                            'is-invalid':
                                                errors.sst_registration_no,
                                        }" />
                                    <div class="invalid-feedback">
                                        {{ errors.sst_registration_no }}
                                    </div>
                                </div>
                            </div>

                            <!-- Vendor Type -->
                            <div class="col-sm-6">
                                <div class="form-group mb-1">
                                    <label class="d-block">Vendor Type <span class="require">*</span></label>
                                    <div class="w-100">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group mb-3">
                                                    <select class="form-select" required  :disabled="showAll && !editable" v-model="form.vendor_type
                                                        " v-bind:class="{
        'is-invalid':
            errors.vendor_type,
    }">
                                                        <option value="Local">
                                                            Local
                                                        </option>
                                                        <option value="Foreign">
                                                            Foreign
                                                        </option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{ errors.vendor_type }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="validationCustom02">TIN <span
                                            class="require">*</span></label>
                                    <input type="text" class="form-control" maxlength="20"
                                        placeholder="TIN" v-model="form.tin"  :disabled="showAll && !editable" v-bind:class="{
                                            'is-invalid':
                                                errors.tin,
                                        }" />
                                    <div class="invalid-feedback">
                                        {{ errors.tin }}
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <!-- <div class="form-group mb-3">
                                    <label for="validationCustom02">MSIC Code <span
                                            class="require">*</span></label>
                                    <input type="text" class="form-control" maxlength="20"
                                        placeholder="MSIC Code" v-model="form.msic_code"  :disabled="showAll && !editable" v-bind:class="{
                                            'is-invalid':
                                                errors.msic_code,
                                        }" />
                                    <div class="invalid-feedback">
                                        {{ errors.msic_code }}
                                    </div>
                                </div> -->

                                <div class="form-group mb-3">
                                            <label>MSIC Code</label>
                                            <select class="form-select" v-model="form.msic_code" :disabled="showAll && !editable" v-bind:class="{
                                                    'is-invalid': errors.msic_code,
                                                }">
                                                <option value="" selected>--select--</option>
                                                <option v-for="msicCode in msicCodes" :value="msicCode.Code">{{ msicCode.Description + " (" + msicCode.Code + ")" }}</option>
                                            </select>
                                                <div class="invalid-feedback">
                                                    {{ errors.msic_code }}
                                                </div>
                                            </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-1">
                                    <div class="w-100">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group mb-3">
                                    <label class="d-block">ID Type <span class="require">*</span></label>

                                                    <select class="form-select" required  :disabled="showAll && !editable" v-model="form.id_type
                                                        " v-bind:class="{
                                                            'is-invalid':
                                                                errors.id_type,
                                                        }">
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
                                                        {{ errors.id_type }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group mb-3">
                                                    <label for="validationCustom02">ID Value <span
                                                            class="require">*</span></label>
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
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- contact person -->
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01">Contact Person 1 <span
                                                    class="require">*</span></label>
                                            <input type="text" placeholder="Contact Person" class="form-control mb-1"
                                                maxlength="30" v-model="form.contact_person_one"  :disabled="showAll && !editable" v-bind:class="{
                                                    'is-invalid':
                                                        errors.contact_person_one,
                                                }" />
                                            <div class="invalid-feedback">
                                                {{ errors.contact_person_one }}
                                            </div>
                                            <input type="text" placeholder="Designation" class="form-control" maxlength="30"
                                                v-model="form.designation_one"  :disabled="showAll && !editable" v-bind:class="{
                                                    'is-invalid':
                                                        errors.designation_one,
                                                }" />
                                            <div class="invalid-feedback">
                                                {{ errors.designation_one }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01">Contact Person 2</label>
                                            <input type="text" placeholder="Contact Person" class="form-control mb-1"
                                                maxlength="30" v-model="form.contact_person_two"  :disabled="showAll && !editable" v-bind:class="{
                                                    'is-invalid':
                                                        errors.contact_person_two,
                                                }" />
                                            <div class="invalid-feedback">
                                                {{ errors.contact_person_two }}
                                            </div>
                                            <input type="text" placeholder="Designation" class="form-control" maxlength="30"
                                                v-model="form.designation_two"  :disabled="showAll && !editable" v-bind:class="{
                                                    'is-invalid':
                                                        errors.designation_two,
                                                }" />
                                            <div class="invalid-feedback">
                                                {{ errors.designation_two }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="validationCustom01">Contact Person 3</label>
                                            <input type="text" placeholder="Contact Person" class="form-control mb-1"
                                                maxlength="30" v-model="form.contact_person_three"  :disabled="showAll && !editable" v-bind:class="{
                                                    'is-invalid':
                                                        errors.contact_person_three,
                                                }" />
                                            <div class="invalid-feedback">
                                                {{ errors.contact_person_three }}
                                            </div>
                                            <input type="text" placeholder="Designation" class="form-control" maxlength="30"
                                                v-model="form.designation_three"  :disabled="showAll && !editable" v-bind:class="{
                                                    'is-invalid':
                                                        errors.designation_three,
                                                }" />
                                            <div class="invalid-feedback">
                                                {{ errors.designation_three }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Note -->
                            <div class="col-12"></div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-4" v-if="isRegistering || (showAll &&editable)">
                                        <p class="text-secondary">
                                            <strong>*Note:</strong>
                                            Please attach your company profile
                                            (Including Certified true copy of Form
                                            9, 24, 49 / SSM Certified)
                                        </p>
                                        <p class="text-muted font-italic mb-1">
                                            Acceptable file type: jpg, jpeg, png,
                                            doc, docx, pdf, xls, xlsx.
                                        </p>
                                    </div>
                                    <div class="w-100 add-more-file" v-if="isRegistering || (showAll &&editable)">
                                        <div id="profile">
                                            <!-- <div v-for="item in add_files_html.profile">
                                            <span v-html="item"></span>
                                        </div> -->
                                            <div class="row">
                                                <div class="form-group mb-1 col-12 col-md-6">

                                                    <label>Latest Business Registration<span
                                                            class="require" v-if="form.type == 1">*</span></label>
                                                    <input type="file" class="form-control" multiple  :disabled="showAll && !editable"
                                                        name="latest_business_registration"
                                                        ref="latest_business_registration"
                                                        :class="{ 'is-invalid': errors.latest_business_registration }" />
                                                    <div class="text-danger small show mb-2">
                                                        {{ errors.latest_business_registration }}
                                                    </div>
                                                </div>
                                                <div class="form-group mb-1 col-12 col-md-6">
                                                    <label>Borang P<span class="require" v-if="form.type == 1">*</span></label>
                                                    <input type="file" class="form-control" multiple name="borang_p"  :disabled="showAll && !editable"
                                                        ref="borang_p" :class="{ 'is-invalid': errors.borang_p }" />
                                                    <div class="text-danger small show mb-2">
                                                        {{ errors.borang_p }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group mb-1 col-12 col-md-6">
                                                    <label>Form 49<span class="require" v-if="form.type == 1">*</span></label>
                                                    <input type="file" class="form-control" multiple name="form_49"  :disabled="showAll && !editable"
                                                        ref="form_49" :class="{ 'is-invalid': errors.form_49 }" />
                                                    <div class="text-danger small show mb-2">
                                                        {{ errors.form_49 }}
                                                    </div>
                                                </div>
                                                <div class="form-group mb-1 col-12 col-md-6">
                                                    <label>Photocopy IC<span class="require" v-if="form.type != 1">*</span></label>
                                                    <input type="file" class="form-control" multiple name="photocopy_ic"  :disabled="showAll && !editable"
                                                        ref="photocopy_ic" :class="{ 'is-invalid': errors.photocopy_ic }" />
                                                    <div class="text-danger small show mb-2">
                                                        {{ errors.photocopy_ic }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-danger small show mb-2">
                                            {{ errors.profile }}
                                        </div>
                                        <!-- <a @click="addMoreFile('profile')"
                                        class="link mb-2 d-inline-block cursor-pointer"><i class="uil uil-plus"></i> Add
                                        More File</a> -->
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <!-- Section B -->
                    <div class="w-100 p-2 bg-light p-2 mb-3" v-if="isRegistering || showAll">
                        <h5 class="m-0">B. Banking Information</h5>
                    </div>
                    <div class="row px-2" v-if="isRegistering || showAll">
                        <!-- Bank Name -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="bank_name">Bank Name <span class="require">*</span></label>
                                <input type="text" class="form-control" maxlength="50" placeholder="Bank Name" v-model="form.bank_name"  
                                :disabled="showAll && !editable"
                                    v-bind:class="{
                                        'is-invalid': errors.bank_name,
                                    }" />
                                <div class="invalid-feedback">
                                    {{ errors.bank_name }}
                                </div>
                            </div>
                        </div>
                        <!-- Swift Code -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="swift_code">Swift Code <span class="require">*</span></label>
                                <input type="text" class="form-control" maxlength="20" placeholder="Swift Code" v-model="form.swift_code"  :disabled="showAll && !editable"
                                    v-bind:class="{
                                        'is-invalid': errors.swift_code,
                                    }" />
                                <div class=" invalid-feedback">
                                    {{ errors.swift_code }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            
                        <!-- Bank Branch -->
                        <div class="col">
                            <div class="form-group mb-3">
                                <label for="bank_branch">Bank Branch <span class="require">*</span></label>
                                <input type="text" class="form-control" maxlength="20" placeholder="Bank Branch" v-model="form.bank_branch"  :disabled="showAll && !editable"
                                    v-bind:class="{
                                        'is-invalid': errors.bank_branch,
                                    }" />
                                <div class=" invalid-feedback">
                                    {{ errors.bank_branch }}
                                </div>
                            </div>
                        </div>

                        <!-- Bank Account No-->
                        <div class="col">
                            <div class="form-group mb-3">
                                <label for="annualturnover">Bank Account No <span class="require">*</span></label>
                                <input type="text" class="form-control" maxlength="30" placeholder="Bank Account No"  :disabled="showAll && !editable"
                                    v-model="form.bank_account_no" v-bind:class="{
                                        'is-invalid': errors.bank_account_no,
                                    }" />
                                <div class="invalid-feedback">
                                    {{ errors.bank_account_no }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-6">
                        <!-- Bank Address 1 -->
                        <div class="col">
                            <div class="form-group mb-3">
                                <label for="bank_branch">Bank Address 1 </label>
                                <input type="text" class="form-control" maxlength="50" placeholder="Bank Address 1" v-model="form.bank_address_one"  :disabled="showAll && !editable"
                                    v-bind:class="{
                                        'is-invalid': errors.bank_address_one,
                                    }" />
                                <div class=" invalid-feedback">
                                    {{ errors.bank_address_one}}
                                </div>
                            </div>
                        </div>
                        <!-- Bank Address 2 -->
                        <div class="col">
                            <div class="form-group mb-3">
                                <label for="bank_branch">Bank Address 2 </label>
                                <input type="text" class="form-control" maxlength="50" placeholder="Bank Address 2" v-model="form.bank_address_two"  :disabled="showAll && !editable"
                                    v-bind:class="{
                                        'is-invalid': errors.bank_address_two,
                                    }" />
                                <div class=" invalid-feedback">
                                    {{ errors.bank_address_two }}
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- Note -->
                        <div class="col-6" v-if="isRegistering || (showAll &&editable)">
                            <div class="form-group mb-3">

                                <label>Bank Statement <span class="require">*</span></label>
                                <input type="file" class="form-control" multiple ref="bank_statement"  :disabled="showAll && !editable"
                                    name="bank_statement" v-on:change="
                                        handleFileUpload(
                                            'bank_statement',
                                            'bank_statement'
                                        )
                                        " :class="{ 'is-invalid': errors.bank_statement }" />
                                <div id="bank_statement" class="text-danger small mb-2 show">
                                    {{ errors.bank_statement }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section C-->
                    <div class="w-100 p-2 bg-light p-2 mb-3" v-if="isRegistering || showAll">
                        <h5 class="m-0">C. Credit Term Offered</h5>
                    </div>
                    <div class="row px-2" v-if="isRegistering || showAll">
                        <div class="col-sm-6 col-12">
                            <div class="form-group mb-3">
                                <select class="form-select" v-model="form.credit_term_offered"  :disabled="showAll && !editable" v-bind:class="{
                                    'is-invalid':
                                        errors.credit_term_offered,
                                }" v-on:change="
    delete form.credit_term_offered_other
    ">
                                    <option :value="null" selected>Select</option>
                                    <option value="30 days">30 Days</option>
                                    <option value="60 days">60 Days</option>
                                    <option value="90 days">90 Days</option>
                                    <option value="other">
                                        Other (Please Specify)
                                    </option>
                                </select>
                                <div class="invalid-feedback">
                                    {{ errors.credit_term_offered }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12" v-if="form.credit_term_offered === 'other'">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" maxlength="50"  placeholder="Other" :disabled="showAll && !editable"
                                    v-model="form.credit_term_offered_other" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" v-if="isRegistering">
                        <div class="col-12">
                            <hr />
                            <h5 class="heading-sm">INSTRUCTIONS</h5>
                            <ul class="instruction-steps">
                                <li class="active">
                                    <p class="step-heading">
                                        Step 1. Complete all the fields above.
                                        Once completed click view.
                                        <span class="status incomplete" v-if="is_download === true">Complete</span><span
                                            class="status incomplete" v-else="is_download === false">Incomplete</span>
                                    </p>
                                    <div class="step-strip">
                                        <div class="text">
                                            <p>
                                                Vendor Lettter of Declaration (VLOD)
                                            </p>
                                        </div>
                                        <div class="action">
                                            <button class="btn" type="button" @click="printPdf('submit')">
                                                View
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                
                                <li id="complete-submission" :class="upload_pdf == true ? 'active' : ''
                                    ">
                                    <p class="step-heading">
                                        Step 2. Check the box to acknowledge. Once acknowledged click complete .
                                        <span class="status incomplete" v-if="is_complete == true">Complete</span><span
                                            class="status incomplete" v-else="is_complete == false">Incomplete</span>
                                    </p>
                                    <div class="step-strip">
                                        <div class="text max-w-100-p d-flex">
                                            <input style="border:0.1px solid #333" type="checkbox" name="terms_agreed" id="terms_agreed" :disabled="
                                            // form.is_print_upload != 1 &&
                                                form.is_print != 1" v-model="isAgreedChecked"
                                                class="mx-1 form-check-input min-w-4">
                                            <p classs="d-inline-block">I/We hereby confirm that the information provided
                                                herein is accurate, correct
                                                and complete and that the documents submitted along with
                                                this application form are genuine. I/We, hereby undertake and agree to
                                                indemnify you from any claims, actions, damages, losses, costs,
                                                charges, expenses, or payments which you may suffer, incur or become liable
                                                for in respect of any payments made by you to me/us via any
                                                online payment channel.</p>
                                        </div>
                            
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
                <div class="col-12 d-flex justify-content-center gap-4" v-if="form.status === 4 && editable ">
                    <button class="btn btn-outline-primary" @click="editable = false; showAll=false">Cancel</button>
                    <button class="btn btn-success" @click="updateForm">Update</button>
                </div>
            </div>
            <!-- Registered -->
            <div class="card-body p-4" v-else-if="form.status === 2">
                <p class="text-center">
                    <strong>Thank You!</strong>
                    <p>Your submission has been received.</p>
                </p>
            </div>
            <div class="d-flex justify-content-center py-2 pt-0"><button type="button"  class="col-2 btn btn-outline-secondary" v-if="!isRegistering && (form.status === 4 && !editable )" @click="showAll =!showAll">{{showAll?'Hide All':'Show More'}}
                <!-- <unicon :name="showAll?'arrow-up':'arrow-down'" fill="dark"></unicon> -->
            </button></div>
        </div>
        <ResetPassword isChangePassword="false" v-if="!isRegistering"></ResetPassword>
        <div class="row mt-3" v-if="form.status === 1|| form.status === 3">
            <div class="col-4 text-center">
                <div class="col-12 text-center mt-3 mb-3">
                            <button class="btn btn-rounded save-draft mr-2 btn-md" type="button" @click="printPdf('save')">
                                Save Draft
                            </button>
                        </div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="col-12 text-center mt-3 mb-3">
                            <button class="btn btn-rounded save-draft mr-2 btn-md" type="button" @click="printPdf('save',true)">
                                Save Draft & Sign Out
                            </button>
                            <small class="d-block mt-2">Draft will be removed if there are no updates in 30 days.</small>
                        </div>
            </div>
            <div class="col-4 text-center">
                <div class="col-12 text-center mt-3 mb-3">
                                            <button class="btn btn-rounded save-draft mr-2 btn-md" :disabled="
                                                form.is_print == 0 || !isAgreedChecked" type="button"
                                                @click="finalSubmission">
                                                Complete and Submit
                                            </button>
                            </div>
            </div>
            <!-- end col -->
        </div>
        <Footer v-if="isRegistering"></Footer>
    </div>
</template>
<script lang="ts">
import apiService from "../commons/apiService";
import Errors from "../commons/Errors";
import Events from "../commons/Events.js";
import moment from "moment";
import Footer from "./../layouts/footer.vue";
import errors from '../commons/Errors';
import ResetPassword from "./../reset-password/reset-password.vue"
import axios from "axios";
export default {
    components: { ResetPassword,Footer },
    data() {
        return {
            apiService: new apiService(),
            companyLogoUrl: "",
            isAgreedChecked: false,
            showAll: false,
            // editable: false,
            editable:  localStorage.getItem("status") === "1" || localStorage.getItem("status") === "3",
            isRegistering: localStorage.getItem("status") === "1" || localStorage.getItem("status") === "3",
            token: "",
            certification: [],
            is_disable: false,
            is_upload: false,
            // is_upload_pdf: false,
            is_attach: false,
            upload_pdf: false,
            is_download: false,
            is_complete: false,
    
            state_list:[],
            country_list: [],
            msic_codes: [],
            countrySearch:'',
            add_files_html: {
                certificates: [
                    ` <div class="form-group mb-1">
                                                <input type="file" class="form-control cw-100" name="certificates[]" />
                                            </div>`,
                ],
                products: [
                    ` <div class="form-group mb-1">
                                                <input type="file" class="form-control cw-100" name="products[]" />
                                            </div>`,
                ],
                product_catalogue: [
                    ` <div class="form-group mb-1">
                                                <input type="file" class="form-control cw-100" name="product_catalogue[]" />
                                            </div>`,
                ],
                profile: [
                    ` <div class="form-group mb-1">
                                                <input type="file" class="form-control cw-100" name="profile[]" />
                                            </div>`,
                ],
            },
            form: {
                id: "",
                company_name: "",
                company_reg_no: "",
                registered_address_one: "",
                registered_address_two: "",
                city: "",
                state: '',
                zip_code: "",
                country: "",
                mailing_address_one: "",
                mailing_address_two: "",
                tel_no: "",
                fax_no: "",
                company_website: "",
                // email: "",
                username: "",
                registered_email_address: "",
                type_of_company: null,
                type_of_company_other: "",
                date_of_incorporation: null,
                vendor_type: null,
                tin: null,
                msic_code: null,
                id_type: null,
                id_value: null,
                type: 1,
                // year_in_operation: "",
                sst_registration_no: "",
                contact_person_one: "",
                designation_one: "",
                contact_person_two: "",
                designation_two: "",
                contact_person_three: "",
                designation_three: "",
                bank_name: "",
                swift_code: "",
                bank_branch: "",
                bank_account_no: "",
                bank_address_one: "",
                bank_address_two: "",
                bank_statement: null,
                // cash_bank_balance: "",
                // product_desc_one: "",
                // product_desc_two: "",
                // product_desc_three: "",
                // product_desc_four: "",
                // product_desc_five: "",
                // product_desc_six: "",
                credit_term_offered: null,
                credit_term_offered_other: "",
                certification_other: "",
                litigation_records: null,
                litigation_records_other: "",
                // registered_email_address_other: "",
                // declaration_by_supplier: "",
                // supplier_pdf: "",
                // name: "",
                // designation: "",
                // date: null,
                anti_bribery_acknowledgement: false,
                status: 1,
            },
            errors: {},
            backend_errors: {},
        };
    },
    created: function () {
        this.token = localStorage.getItem("token");
        this.getUserDetails();
        const me = this;
        this.getCountry();
        this.getMsicCodes();
        document.addEventListener("click", function (e) {
            if (e.target && e.target.matches(".remove-div, .remove-div *")) {
                me.removeFileUpload(e.target.id);
            }
        });
    },
    computed: {
        addFileArray: function () {
            return this.add_files_html.value;
        },
        isDisabled: function () {
            return !this.is_disable;
        },
        isUpload: function () {
            return !this.is_upload;
        },
        countryList: function (){
            return this.country_list //.filter(e=> e.includes(this.countrySearch));
        },
        stateList: function (){
            return this.state_list //.filter(e=> e.includes(search));
        },
        msicCodes: function (){
            return this.msic_codes;
        }
    },

    watch: {
        'form.id_type'(newValue) {
            if (newValue === 'BRN' || newValue === 'NRIC') {
                this.form.id_value = this.form.company_reg_no;
            }else{
                this.form.id_value = null;
            }
        }
    },

    updated() {
        this.initDatepicker();
    },

    methods: {
        sameAddress(event){
            if(event.target.checked){
                this.form.mailing_address_one=this.form.registered_address_one
                this.form.mailing_address_two=this.form.registered_address_two
            }
        },
        editForm(){
            this.showAll = true;
            this.editable = true;
        },
        updateForm(){
            let errorMessages = Errors.registration;
                this.errors = [];
                Object.keys(errorMessages).forEach((data) => {
                    if (!this.form[data]) {
                        this.errors[data] = errorMessages[data];
                    }
                });

                // if(this.form.type == 1   ){this.checkFileValidation("latest_business_registration", "single");
                // this.checkFileValidation("borang_p", "single");
                // this.checkFileValidation("form_49", "single");}else{
                // this.checkFileValidation("photocopy_ic", "single");}
                // this.checkFileValidation("bank_statement_attachments", "single");

                if (Object.keys(this.errors).length) {
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

                const formData = this.createFormData();
                this.$loadingStart();

              this.apiService
                .PostForm(`/api/users/companies/${this.form.id}`, formData)
                .then((res) => {
                    if (res.success) {
                        this.showAll=false;
                        this.editable=false;
                        this.$toast.success(res.message);
                    }
                })
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => {
                    window.scrollTo(0,0);
                    this.$loadingStop()});

        },
        initDatepicker(changeId = "") {
            let dateFields = ["date", "date_of_incorporation"];
            dateFields.forEach((data) => {
                this.form[data] = this.form[data]
                    ? this.form[data]
                    : this.$date(new Date(), "YYYY-MM-DD");
                // let date = moment(new Date(this.form[data]));
                // let currentDate = moment();
                // this.form.year_in_operation = currentDate
                //     .diff(date, "years", true)
                //     .toFixed(2);
            });
        },
        openDatePicker() {
            document.querySelector(`#inputDate`).showPicker()
        },
        handleFileUpload(formField, refField) {
            if (refField != "supplier_pdf") {
                this.form[formField] = this.$refs[refField].files[0];
                document.querySelector(`#${refField}`)?.classList.add("d-none");
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
                    // formData.append('unique_id', unique_id);
                    this.$loadingStart()
                    this.apiService
                        .PostForm("/api/users/upload-pdf", formData, {
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                        })
                        .then((res) => {
                            if (res.success) {
                                if (res.data.is_print === 1) {
                                    this.upload_pdf = true;
                                    this.is_download = true;
                                }
                                if (
                                    res.data.is_print === 1 
                                    // &&
                                    // res.data.is_print_upload === 1
                                ) {
                                    this.form.is_print = 1
                                    // this.form.is_print_upload = 1
                                    // this.is_upload_pdf = true;
                                    this.is_attach = true;
                                }
                                this.is_upload = true;
                                this.is_attach = true;
                                this.form.supplier_pdf = res.data.supplier_pdf;
                                document
                                    .querySelector(`#complete-submission`)?.classList.add("active");
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        }).finally(()=>this.$loadingStop());
                }
            }
        },
        getTermsAndConditions() {
            this.$loadingStart();
            this.apiService
                .Get(`/api/terms-and-condition-url`)
                .then((res) => {
                    if (res.success) {
                        const url = res.data
                        const link = document.createElement(
                            "a"
                        ) as HTMLAnchorElement;
                        link.href = url;
                        link.setAttribute("download", "Terms & Conditions");
                        document.body.appendChild(link);
                        link.click();
                    }
                })
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => {
                    this.$loadingStop();
                });
        },
        onKeypress(e, data) {
            Events.onKeypress(e, data);
        },

        onKeypressAcceptNegativeNum(e, data) {
            Events.onKeypressAcceptNegativeNum(e, data);
        },
        getState(){
            this.form.state = '';
            this.apiService
                .Get('/api/countries/'+ this.form.country+'/states')
                .then((res) => {
                    if(res.success){
                        this.state_list = res.data
                    }
                })
        },
        getCountry(){
            this.apiService
                .Get('/api/countryCodes')
                .then((res) => {
                    if(res.success){
                        this.country_list = res.data
                    }
                    
                })
        },
        getMsicCodes(){
            this.apiService
                .Get('/api/msicCodes')
                .then((res) => {
                    console.log(res);
                    if(res.success){
                        this.msic_codes = res.data
                    }
                    
                })
        },

        addMoreFile(id) {
            if (this.add_files_html[id].length < 3) {
                this.add_files_html[id].push(`

            <div class="form-group mb-1" style="display: inline-flex;">
                    <input
                        type="file"
                        class="form-control cw-100"
                        name="${id}[]"
                        />
                        <button type="button" class="remove-div btn btn-light" id="${id + "_"
                    }${this.add_files_html[id].length}">
                            &Cross;
                            </button>
                        </div>
                        `);
            }
        },
        removeFileUpload(self: string) {
            const [key, index] = self.split("_");
            this.add_files_html[key].splice(index, 1);
        },
        downloadFile(apiUrl, name) {
            this.$loadingStart();
            this.apiService
                .Get(apiUrl)
                .then((res) => {
                    this.$loadingStop();
                    if (res.success) {
                        // const url = URL.createObjectURL(new Blob([res?.data]));
                        const link = document.createElement(
                            "a"
                        ) as HTMLAnchorElement;
                        link.href = res.data;
                        link.setAttribute("target","_blank")
                        // link.setAttribute("download", name);
                        document.body.appendChild(link);
                        link.click();
                    } else  if(!res.message.includes("Invalid scope")  ){
                        this.$toast.error(
                            res.message ?? "Something went wrong"
                        );
                    }
                })
                .finally(() => {
                    this.$loadingStop();
                    this.getUserDetails();
                });
        },
        printPdf(type,signOut=false) {
            let condition = this.checkForm(type);
            // this.form.certification = this.certification;
            if (condition) {
                this.loading = true;
                const formData = this.createFormData();
                this.$loadingStart();
                this.apiService
                    .PostForm(`/api/users/companies/${this.form.id}`, formData)
                    .then((res) => {
                        
                        if (res.success) {
                            // this.form.is_print = false;
                            if (type != "save") {
                                let url = `/api/users/companies/${this.form.id}/print-pdf`;
                                this.downloadFile(
                                    url,
                                    "Vendor_Registration_Form.pdf"
                                );
                                // let url = "/api/print-pdf/" + unique_id;
                                // if (window.open(url, "_blank")) {
                                this.is_disable = true;
                                this.is_download = true;
                                document.querySelector(`#upload-pdf`)?.classList.add("active");
                                // }
                            }
                            if(signOut){
                                this.$router.push('/sign-in');
                            }

                            this.$toast.success(res.message);
                        } else {
                            this.errors = { ...this.errors, ...res.errors };
                            this.$toast.error(res.message);
                        }
                    })
                    .catch((error) => {
                        this.backend_errors =
                            error?.errors || {};
                    })
                    .finally(() => {this.loading = false;this.$loadingStop();});
            }
        },
        getUserDetails() {
            this.$loadingStart();
            this.apiService
                .Get(`/api/users/companies/${localStorage.getItem("vendor_no")}`)
                .then((res) => {
                    if (res.success) {
                        if (localStorage.getItem("status") != res.data.status) {
                            this.$router.push('/sign-in');
                        }
                        this.form = {
                            ...this.form,
                            ...res.data,
                        };
                        delete this.form.soap_data;
                        delete this.form.nav_status;
                        delete this.form.attempts;
                        // this.certification = this.form.certification
                        //     ? this.form.certification.split(",")
                        //     : [];
                        // if (res.data.status != 1) {
                        //     this.$toast.success(res.message);
                        // }
                        if (res.data.is_print === 1) {
                            this.upload_pdf = true;
                            this.is_download = true;
                        }
                        if (
                            res.data.is_print === 1 
                            // &&
                            // res.data.is_print_upload === 1
                        ) {
                            // this.is_upload_pdf = true;
                            this.is_attach = true;
                        }
                    }
                })
                .catch((error) => {
                    // error = error.data;
                    this.$toast.error(error.message);
                })
                .finally(() => {
                    this.$loadingStop();
                });
        },
        finalSubmission() {
            let formData = new FormData();
            // formData.append('unique_id', this.$route.params.unique_id);
            // this.loading = true;
            this.$loadingStart();
            this.apiService
                .Post(`/api/users/companies/${this.form.id}/final-submit`, formData)
                .then((res) => {
                    if (res.data.status === 2) {
                        this.form.status = 2;
                        this.is_complete = true;
                    }
                })
                .catch((error) => {
                    error = error.response.data;
                    this.$toast.error(error.message);
                })
                .finally(() => this.$loadingStop());
        },
        saveDetails() {
            let json = {};
            this.$loadingStart();
            this.apiService
                .Post(`/api/users/companies/${this.form.id}`, json)
                .then((res) => {
                    if (res.success) {
                        this.$toast.success(res.message);
                        if (
                            res.success &&
                            localStorage.getItem("status") == "3"
                        ) {
                            this.getUserDetails();
                        } else {
                            this.$router.push("/sign-in");
                        }
                    } else  if(!res.message.includes("Invalid scope")  ){
                        this.$toast.error(
                            res.message ?? "Something went wrong"
                        );
                    }
                })
                .finally(() => {
                    this.$loadingStop();
                });
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

            if (type !== "save") {
                let errorMessages = Errors.registration;
                Object.keys(errorMessages).forEach((data) => {
                    if (!this.form[data]) {
                        this.errors[data] = errorMessages[data];
                    }
                });

                // if (!this.form['anti_bribery_acknowledgement']) {
                //     this.errors['anti_bribery_acknowledgement'] = "Acknowledgment required."
                // }
                // let decValues = [
                //     "bank_name",
                //     "swift_code",
                //     "bank_branch",
                //     "cash_bank_balance",
                //     "bank_account_no",
                // ];
                // decValues.forEach((d) => {
                //     if (
                //         !new RegExp("^[-+]?[1-9]\\d*(\\.\\d+)?$").test(
                //             this.form[d]
                //         )
                //     ) {
                //         this.errors[d] = "Invalid value specified";
                //     }
                // });

                // this.checkFileValidation("certificates", "multi");
                if(this.form.type == 1   ){this.checkFileValidation("latest_business_registration", "single");
                this.checkFileValidation("borang_p", "single");
                this.checkFileValidation("form_49", "single");}else{
                this.checkFileValidation("photocopy_ic", "single");}
                this.checkFileValidation("bank_statement", "single");
                // this.checkFileValidation("products", "multi");
                // this.checkFileValidation("product_catalogue", "multi");
                // this.checkFileValidation("declaration_by_supplier", "single");
                // this.checkFileValidation("supplier_pdf", "single");
                // let filesErr = [
                //     "products",
                //     "certificates",
                //     "profile",
                //     "product_catalogue",
                //     "declaration_by_supplier",
                // ];
                // let errorKeys = Object.keys(this.errors);
                // let filesErrValue = errorKeys.filter(r => filesErr.includes(r));

                if (Object.keys(this.errors).length) {
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
                document
                    .querySelectorAll(`input[name='${param}[]'`)
                    .forEach((data, i) => {
                        this.fileValidator(data, param);
                    });
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
                if (this.form[key] && key != "vendor_no")
                    formData.append(key, this.form[key]);
            }
            // document
            //     .querySelectorAll("input[name='certificates[]']")
            //     .forEach((data, i) => {
            //         this.certificateVal = data.files[0];
            //         if (data.files[0])
            //             formData.append("certificates_" + i, data.files[0]);
            //     });
            Object.values(document
                .querySelectorAll("input[name='latest_business_registration']")[0].files)
                .forEach((data, i) => {
                    if (data)
                        formData.append(`latest_business_registration[${i}]`, data);
                });
            Object.values(document
                .querySelectorAll("input[name='borang_p']")[0].files)
                .forEach((data, i) => {
                    if (data)
                        formData.append(`borang_p[${i}]`, data);
                });
            Object.values(document
                .querySelectorAll("input[name='form_49']")[0].files)
                .forEach((data, i) => {
                    if (data)
                        formData.append(`form_49[${i}]`, data);
                });
            Object.values(document
                .querySelectorAll("input[name='photocopy_ic']")[0].files)
                .forEach((data, i) => {
                    if (data)
                        formData.append(`photocopy_ic[${i}]`, data);
                });
            Object.values(document
                .querySelectorAll("input[name='bank_statement']")[0].files)
                .forEach((data, i) => {
                    if (data)
                        formData.append(`bank_statement[${i}]`, data);
                });
            return formData;
        },

        getOrganizationLogo() {
            this.$loadingStart();
            axios
                .get(
                    "/api/get-organization-logo/" +
                        localStorage.getItem("organization_id")
                )
                .then((res) => res.data)
                .then((res) => {
                    this.companyLogoUrl = res.data.logo_url;
                })
                .catch((error) => {
                    error = error.response.data;
                })
                .finally(() => this.$loadingStop());
        },
    },

    mounted(){
        this.getOrganizationLogo();
    }
};
</script>

<style scoped>
.heading-sm {
    color: #a7a7a7;
    font-weight: 400;
}

.instruction-steps {
    list-style: none;
    padding: 0;
}

.instruction-steps li {
    margin-bottom: 20px;
}

.instruction-steps li p.step-heading {
    color: #a7a7a7;
    margin: 0;
    margin-bottom: 8px;
}

.instruction-steps li p.step-heading .status {
    font-style: italic;
}

.instruction-steps li p.step-heading .status.complete {
    color: #ca2b2b;
}

.instruction-steps li p.step-heading .status.incomplete {
    color: #2ebe6f;
}

.instruction-steps li .step-strip {
    background: #f2f2f2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
}

.instruction-steps li.active .step-strip {
    background: #fad139;
}

.instruction-steps li .step-strip p {
    font-weight: bold;
    color: #000;
    margin: 0;
}

.instruction-steps li .step-strip button.btn {
    background: #fff;
    border: none;
    padding: 5px 20px;
    border-radius: 50px;
    color: #000;
    font-weight: bold;
    min-width: 180px;
    cursor: pointer;
}

.save-draft {
    color: black;
    background-color: white !important;
    border: 1px solid black !important;
}

.no-mouseevents {
    pointer-events: none;
}
</style>
