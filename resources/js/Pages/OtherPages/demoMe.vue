<template>
  <form @submit.prevent="submitBillingDetails">
    <div>
      <label>Full Name:</label>
      <input v-model="form.fullName" type="text" required />
    </div>
    <div>
      <label>Company Name:</label>
      <input v-model="form.companyName" type="text" />
    </div>
    <div>
      <label>Country:</label>
      <input v-model="form.country" type="text" required />
    </div>
    <div>
      <label>State:</label>
      <input v-model="form.state" type="text" required />
    </div>
    <div>
      <label>Address:</label>
      <input v-model="form.address" type="text" required />
    </div>
    <div>
      <label>City:</label>
      <input v-model="form.city" type="text" required />
    </div>
    <div>
      <label>Postal Code:</label>
      <input v-model="form.postalCode" type="text" required />
    </div>
    <div>
      <label>Are you a citizen?:</label>
      <select v-model="form.isCitizen" required>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
      </select>
    </div>
    <div>
      <label>Tax Category:</label>
      <input v-model="form.taxCategory" type="text" required />
    </div>
    <div>
      <label>Want Invoices?:</label>
      <input v-model="form.wantInvoices" type="checkbox" />
    </div>
    <button type="submit">Submit</button>
  </form>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import axios from 'axios';

const form = reactive({
  fullName: '', // make sure you have 'fullName' mapped correctly
  companyName: '',
  country: '',
  state: '',
  address: '',
  city: '',
  postalCode: '', // make sure 'postalCode' is mapped
  isCitizen: '', // make sure 'isCitizen' is mapped
  taxCategory: '', // make sure 'taxCategory' is mapped
  wantInvoices: false,
});

const submitBillingDetails = async () => {
  try {
    const payload = {
      full_name: form.fullName, // make sure field name matches
      company_name: form.companyName,
      country: form.country,
      state: form.state,
      address: form.address,
      city: form.city,
      postal_code: form.postalCode, // make sure field name matches
      is_citizen: form.isCitizen, // make sure field name matches
      tax_category: form.taxCategory, // make sure field name matches
      want_invoices: form.wantInvoices,
    };

    await axios.post('/billing-details', payload);
    alert('Billing details submitted successfully!');
  } catch (error) {
    console.error('Error submitting billing details:', error);
    if (error.response && error.response.data.errors) {
      const errors = error.response.data.errors;
      console.error('Validation errors:', errors);
    }
  }
};
</script>
