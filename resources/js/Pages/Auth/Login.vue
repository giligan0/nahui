<script setup>
import login from '../Multimedia/login.png' 

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
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <div class="login-container">
    <!-- Imagen lateral o de fondo -->
    <div class="background">
        <img :src="login" alt="" class="img_login">
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
          <label for="remember" class="text-sm text-gray-700"
            >Mantener sesión</label
          >
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
          <Link
            :href="route('register')"
            class="btn secondary text-center"
          >
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
    width: 100%;
  display: flex;
  height: 100vh;
  font-family: Arial, sans-serif;

  .background {
    flex: 1;
    }
    .img_login{
    height: 100dvh;
  }
  .login-box {
    flex: 1.4;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: #fefdf6;
    padding: 2rem;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);

    h2 {
      font-size: 1.8rem;
      font-weight: bold;
      margin-bottom: 1.5rem;
      color: #222;
    }

    form {
      width: 100%;
      max-width: 450px;

      .form-group {
        margin-bottom: 1rem;
        position: relative;

        input {
          width: 100%;
          padding: 0.8rem;
          border: 1px solid #ddd;
          border-radius: 6px;
          font-size: 1rem;
          outline: none;
          box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.05);
        }

        &.password {
          .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
          }
        }
      }

      .buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;

        .btn {
          flex: 1;
          padding: 0.8rem;
          border: none;
          border-radius: 6px;
          font-size: 1rem;
          cursor: pointer;
          transition: background 0.3s ease;

          &.primary {
            background: #d68c00;
            color: white;

            &:hover {
              background: #b87400;
            }
          }

          &.secondary {
            background: white;
            border: 1px solid #d68c00;
            color: #d68c00;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;

            &:hover {
              background: #fdf4e2;
            }
          }
        }
      }

      .forgot {
        display: block;
        text-align: center;
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #555;
        text-decoration: none;

        &:hover {
          text-decoration: underline;
        }
      }
    }
  }

  @media (max-width: 768px) {
    flex-direction: column;
    position: relative;

    .background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      filter: brightness(0.5);
      z-index: 0;
    }

    .login-box {
      flex: none;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.9);
      z-index: 1;
      box-shadow: none;
      padding: 2rem;

      form {
        .buttons {
          flex-direction: column;

          .btn {
            width: 100%;
          }
        }
      }
    }
  }
}
</style>
