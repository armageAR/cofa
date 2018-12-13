<template src="./form.html"></template>

<script>
import { Form } from "../Form.vue";

export default {
  data() {
    return {
      form: new Form({
        supplier: {},
        address: {},
        contact: {}
      }),
      destroing: false,
      creating: false,
      loading: true,
      submiting: false
    };
  },
  mounted() {
    this.getSupplier();
  },
  methods: {
    getSupplier() {
      this.loading = true;
      let str = window.location.pathname;
      let res = str.split("/");
      axios
        .get(`/api/suppliers/${res[2]}`)
        .then(response => {
          //console.log(response);
          this.form.supplier = response.data;
          if (this.form.supplier.addresses.length > 0) {
            this.form.address = this.form.supplier.addresses[0];
          }
          if (this.form.supplier.contacts.length > 0) {
            this.form.contact = this.form.supplier.contacts[0];
          }
        })
        .catch(error => {
          this.$toasted.global.error("El proveedor no existe!");
          location.href = "/suppliers";
        })
        .then(() => {
          this.loading = false;
        });
    },
    onSubmit() {
      if (!this.submiting) {
        this.submiting = true;
        this.form
          .update(`/api/suppliers/update/${this.form.supplier.id}`)
          .then(response => {
            this.$toasted.global.error("Proveedor actualizado!");
            location.href = "/suppliers";
          });
        this.submiting = false;
      }
    },
    onDestroy() {
      if (!this.destroing) {
        this.destroing = true;
        this.form
          .destroy(`/api/suppliers/${this.form.supplier.id}`)
          .then(response => {
            this.$toasted.global.error("Proveedor eliminado!");
            location.href = "/suppliers";
          });
        this.destroing = false;
      }
    }
  }
};
</script>
