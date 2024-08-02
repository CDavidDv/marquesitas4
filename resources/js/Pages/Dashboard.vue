<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Tablero from '@/Components/tablero/Tablero.vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();

defineProps({
  bebidas: {
    type: Object,
    required: true
  },
  ingredientes: {
    type: Object,
    required: true
  },
  ordens: {
    type: Object,
    required: true
  },
  categorias: {
    type: Object ,
    required: true
  },
  tableroAdmin: {
    type: Object,
    required: true,
    default: () => ({
      ingredientes: [],
      bebidas: [],
      ordens: [],
      ventasHoy: 0,
      ventasMes: 0,
      ventasMesAnterior: 0,
      diferenciaPorcentual: 0,
      numeroVentasMesAnterior: 0,
      numeroVentasMes: 0,
      sucursalConMasVentas: 0,
      salesData: []
    })
  }
});

</script>

<template>
    <AppLayout title="Tablero">
        <div class="py-1 sm:py-4">
            <div class="max-w mx-auto sm:px-6 lg:px-8">
                <div class=" overflow-hidden  sm:rounded-lg">
                    <Welcome v-if="$page.props.auth.user.sucursal_id > 0 " :bebidas="bebidas" :ingredientes="ingredientes" :ordens="ordens" :categorias="categorias" />
                    <Tablero v-else :tableroAdmin="tableroAdmin" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
