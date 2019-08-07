<template>
    <span>{{ translated }}</span>
</template>

<script>
export default {
  computed: {
    translated: function() {
      return t("twofactor_email", this.text, this.options || {});
    }
  },
  props: ["text", "options"]
};
</script>
