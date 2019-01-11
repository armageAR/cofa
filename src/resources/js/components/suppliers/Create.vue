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
      creating: true,
      loading: true,
      submiting: false
    };
  },
  mounted() {},
  methods: {
    onSubmit() {
      if (!this.submiting) {
        this.submiting = true;
        this.form.create(`/api/suppliers/store`).then(response => {
          this.$toasted.global.error("Proveedor creado!");
          location.href = "/suppliers";
        });
        this.submiting = false;
      }
    }
  }
};
</script>
