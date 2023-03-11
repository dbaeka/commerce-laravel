<template>
    <div>
        <div>
            <h2 class="text-lg font-medium text-gray-900">Contact information</h2>
            <BaseInput
                div-class="mt-4"
                type="email"
                v-model="form.email"
                id="email-address"
                label="Email address"
                name="email-address"
                autocomplete="email"
                v-model:error="formErrors.email"
                required
            >
            </BaseInput>
        </div>

        <div class="mt-10 border-t border-gray-200 pt-10">
            <h2 class="text-lg font-medium text-gray-900">Shipping information</h2>

            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                <BaseInput
                    type="text"
                    v-model="form.first_name"
                    id="first-name"
                    label="First name"
                    name="first-name"
                    autocomplete="given-name"
                    v-model:error="formErrors.first_name"
                    required
                >
                </BaseInput>

                <BaseInput
                    type="text"
                    v-model="form.last_name"
                    id="last-name"
                    label="Last name"
                    name="last-name"
                    autocomplete="family-name"
                    v-model:error="formErrors.last_name"
                    required
                >
                </BaseInput>

                <BaseInput
                    div-class="sm:col-span-2"
                    type="text"
                    v-model="form.address"
                    id="address"
                    label="Address"
                    name="address"
                    autocomplete="street-address"
                    v-model:error="formErrors.address"
                    required
                >
                </BaseInput>

                <BaseInput
                    div-class="sm:col-span-2"
                    type="text"
                    v-model="form.apartment_suite"
                    id="apartment"
                    label="Apartment, suite, etc."
                    name="apartment"
                    v-model:error="formErrors.apartment_suite"
                >
                </BaseInput>

                <BaseInput
                    type="text"
                    v-model="form.city"
                    id="city"
                    label="City"
                    name="city"
                    autocomplete="address-level2"
                    v-model:error="formErrors.city"
                    required
                >
                </BaseInput>

                <BaseSelect
                    v-model="form.country"
                    id="country"
                    label="Country"
                    name="country"
                    autocomplete="country-name"
                    v-model:error="formErrors.country"
                    required
                >
                    <option v-for="country in countries" :value="country" :key="country.uuid">{{ country }}</option>
                </BaseSelect>

                <BaseInput
                    type="text"
                    v-model="form.state_province"
                    id="region"
                    label="State / Province"
                    name="region"
                    autocomplete="address-level1"
                    v-model:error="formErrors.state_province"
                    required
                >
                </BaseInput>

                <BaseInput
                    type="text"
                    v-model="form.postal_code"
                    id="postal-code"
                    label="Postal code"
                    name="postal-code"
                    autocomplete="postal-code"
                    v-model:error="formErrors.postal_code"
                    required
                >
                </BaseInput>

                <BaseInput
                    div-class="sm:col-span-2"
                    type="text"
                    v-model="form.phone"
                    id="phone"
                    label="Phone"
                    placeholder="(0xx) xxx-xxxx"
                    name="phone"
                    autocomplete="tel"
                    v-model:error="formErrors.phone"
                    required
                    pattern="\([0-9]{3}\) [0-9]{3}-[0-9]{4}"
                >
                </BaseInput>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CheckoutForm"
}
</script>
<script setup>
import {computed} from "vue";
import {useStore} from "vuex";
import {sortedCountries} from "../../helpers";

const store = useStore()

const formErrors = computed(() => store.getters["checkout/getFormErrors"]);
const form = computed(() => store.getters["checkout/getForm"]);

const countries = sortedCountries();
</script>
