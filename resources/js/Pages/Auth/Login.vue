<script setup>
import login from "../Multimedia/login.png";
import { useForm, Link } from "@inertiajs/vue3";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faEye } from "@fortawesome/free-solid-svg-icons";

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {   // ✅ usa route() directamente
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <div class="login-container">
    <!-- Imagen lateral -->
    <div class="background">
      <img :src="login" alt="" class="img_login" />
    </div>

    <div class="login-box">
      <h2>Inicio de sesión</h2>

      <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
        {{ status }}
      </div>

      <form @submit.prevent="submit">
        <!-- Usuario/Email -->
        <div class="form-group">
          <input
            type="email"
            placeholder="Correo"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
          />
          <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
            {{ form.errors.email }}
          </div>
        </div>

        <!-- Password -->
        <div class="form-group password">
          <input
            type="password"
            placeholder="Contraseña"
            v-model="form.password"
            required
            autocomplete="current-password"
          />
          <font-awesome-icon :icon="faEye" class="eye-icon" />
          <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">
            {{ form.errors.password }}
          </div>
        </div>

        <!-- Remember me -->
        <div class="mt-2 flex items-center gap-2">
          <input
            type="checkbox"
            id="remember"
            v-model="form.remember"
            class="rounded border-gray-300"
          />
          <label for="remember" class="text-sm text-gray-700">
            Mantener sesión
          </label>
        </div>

        <!-- Botones -->
        <div class="buttons">
          <button
            type="submit"
            class="btn primary"
            :disabled="form.processing"
            :class="{ 'opacity-50': form.processing }"
          >
            Iniciar sesión
          </button>
          <Link :href="route('register')" class="btn secondary text-center">
            Crear cuenta nueva
          </Link>
        </div>

        <!-- Forgot password -->
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="forgot"
        >
          ¿Olvidaste tu contraseña?
        </Link>
      </form>
    </div>
  </div>
</template>

<style lang="scss" scoped>
/* ✅ tu CSS queda igual */
</style>
