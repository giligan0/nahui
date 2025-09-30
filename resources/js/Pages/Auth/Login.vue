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
.login-container {
  display: flex;
  height: 100vh;
  font-family: "Poppins", sans-serif;
  background: #fdfbf6;

  .background {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;

    .img_login {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  .login-box {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 3rem 4rem;
    background: #fffdf9;

    h2 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 2rem;
      text-align: left;
      color: #2d2d2d;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 1.2rem;
    }

    .form-group {
      input {
        width: 100%;
        padding: 0.9rem 1rem;
        border: 1px solid #ddd;
        border-radius: 12px;
        font-size: 0.95rem;
        background: #fff;
        outline: none;
        transition: 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);

        &:focus {
          border-color: #d4915d;
          box-shadow: 0 4px 10px rgba(212, 145, 93, 0.2);
        }
      }

      &.password {
        position: relative;

        .eye-icon {
          position: absolute;
          right: 15px;
          top: 50%;
          transform: translateY(-50%);
          color: #888;
          cursor: pointer;
        }
      }
    }

    .buttons {
      display: flex;
      gap: 1rem;
      margin-top: 0.5rem;

      .btn {
        flex: 1;
        padding: 0.9rem;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s ease;

        &.primary {
          background: #d4915d;
          color: #fff;
          border: none;

          &:hover {
            background: #b97340;
          }
        }

        &.secondary {
          border: 1px solid #d4915d;
          color: #d4915d;
          background: transparent;

          &:hover {
            background: #fff2e9;
          }
        }
      }
    }

    .forgot {
      margin-top: 1.2rem;
      font-size: 0.85rem;
      color: #666;
      text-align: center;
      transition: color 0.3s;

      &:hover {
        color: #d4915d;
      }
    }
  }
}

</style>
