<script setup>
import { onMounted, reactive, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const { props } = usePage();

const ingredientes = ref(props.ingredientes || []);
const bebidas = ref(props.bebidas || []);
const ingredientesInventario = ref(props.ingredientesInventario || []);
const bebidasInventario = ref(props.bebidasInventario || []);
const sucursal = ref(props.sucursal || '');
const error = ref('');
const errorNuevoBebida = ref('');
const errorNuevoIngrediente = ref('');

const nuevoItem = reactive([]);

console.log(props.categorias.length)

props.categorias.forEach(categoria => {
  nuevoItem[categoria.id] = { nombre: '', precio: '', cantidad: '' };
  console.log(nuevoItem);
});

const itemsporcat = ref(props.itemsporcat || []);
const nuevaCategoria = ref('')

const categorias = ref(props.categorias || []);
const errorNuevoItem = ref({}); // Error específico para cada item
const errorNuevoCategoria = ref('');

const errorNuevoItemCat = ref({})

const form = reactive({
  sucursal_id: sucursal.value,
  ingredientes: ingredientes.value?.map(i => ({
    id: i?.id,
    nombre: i?.nombre,
    cantidad: (ingredientesInventario.value.find(inv => inv?.id === i?.id)?.cantidad) || 0.00,
    precio: i?.precio || 0
  })) || [],
  bebidas: bebidas.value?.map(b => ({
    id: b?.id,
    nombre: b?.nombre,
    cantidad: (bebidasInventario.value.find(inv => inv?.id === b?.id)?.cantidad) || 0.00,
    precio: b?.precio || 0
  })) || [],
  ingredientesInventario: ingredientesInventario.value?.map(i => ({
    id: i?.id,
    nombre: i?.nombre,
    cantidad: i?.cantidad || 0.00,
    precio: i?.precio || 0
  })) || [],
  bebidasInventario: bebidasInventario.value?.map(b => ({
    id: b?.id,
    nombre: b?.nombre,
    cantidad: b?.cantidad || 0.00,
    precio: b?.precio || 0
  })) || [],
  categorias: categorias.value?.map(categoria => ({
    id: categoria?.id,
    nombre: categoria?.nombre,
    items: categoria?.items.map(item => ({
      id: item?.id,
      nombre: item?.nombre,
      precio: item?.precio || 0,
      cantidad: item?.cantidad || 0
    })) || [],

  })) || []

});


const submit = () => {
  console.log('Datos enviados:', form);  // Depuración
  router.post('/inventarioi', form, {
    onSuccess: () => {
      console.log('Inventario actualizado con éxito');
    },
    onError: (errors) => {
      console.error('Error al actualizar el inventario:', errors);
    }
  });
};


const agregarItem = (categoriaId) => {
  const categoria = form.categorias.find(c => c.id === categoriaId);
  if (categoria) {
    const { nombre, precio } = nuevoItem[categoriaId] || { nombre: '', precio: '' };

    if (!nombre || !precio) {
      errorNuevoItemCat.value[categoriaId] = 'Nombre y precio son requeridos';
      return;
    }

    router.post('/itemsi', {
      categoria_id: categoriaId,
      nombre,
      precio
    }, {
      onSuccess: (response) => {
        nuevoItem[categoriaId] = { nombre: '', precio: '' }; // Limpiar campos del nuevo ítem
        
        // Obtener el último ítem agregado
        const lastIngrediente = response.props.categorias.find(c => c.id === categoriaId).items.slice(-1)[0];

        // Actualizar la categoría específica con el nuevo ítem
        form.categorias = form.categorias.map(categoria => {
          if (categoria.id === categoriaId) {
            return {
              ...categoria,
              items: [...categoria.items, lastIngrediente] // Mantener los ítems existentes y agregar el nuevo
            };
          }
          return categoria;
        });

        delete errorNuevoItemCat.value[categoriaId]; // Limpiar errores para la categoría específica
      },
      onError: (errors) => {
        console.error('Error al agregar el ítem:', errors);
      }
    });
  }
};




const eliminarItem = (categoriaId, itemId) => {
  router.delete(`/itemsi/${itemId}`, {
    onSuccess: (response) => {
      // Actualizar el estado de las categorías eliminando el ítem
      form.categorias = form.categorias.map(categoria => {
        if (categoria.id === categoriaId) {
          return {
            ...categoria,
            items: categoria.items.filter(item => item.id !== itemId)
          };
        }
        return categoria;
      });

      // Limpiar el nuevo ítem para la categoría específica
      nuevoItem[categoriaId] = { nombre: '', precio: '', cantidad: '' };

      console.log('Categorías después de eliminar:', form.categorias); // Depuración
    },
    onError: (errors) => {
      console.error('Error al eliminar el ítem:', errors);
    }
  });
};






const editarItem = (categoriaId, itemId) => {
  // Encuentra la categoría y el ítem
  const categoria = form.categorias.find(c => c.id == categoriaId);
  const item = categoria ? categoria.items.find(i => i.id == itemId) : null;

  if (item) {
    // Validaciones
    if (!item.nombre || item.nombre.trim() == '') {
      errorNuevoItem.value[itemId] = 'El nombre está vacío o solo contiene espacios';
      return;
    }
    if (!item.precio || isNaN(item.precio) || Number(item.precio) == 0) {
      errorNuevoItem.value[itemId] = 'El precio está vacío, no es válido o es 0';
      return;
    }

    // Enviar solicitud PUT para actualizar el ítem
    router.put(`/itemsi/${itemId}`, item, {
      onSuccess: (response) => {
        console.log('Item actualizado con éxito');

        // Obtener la última categoría con los ítems actualizados
        const updatedCategory = response.props.categorias.find(c => c.id == categoriaId);
        if (updatedCategory) {
          form.categorias = form.categorias.map(c => 
            c.id == categoriaId ? updatedCategory : c
          );
        }

        // Limpiar error para el ítem específico
        delete errorNuevoItem.value[itemId];
      },
      onError: (errors) => {
        console.error('Error al actualizar el ítem:', errors);
      }
    });
  }
};





const handleAddNewCategory = () => {
  // Validar que el nombre de la categoría no esté vacío
  if (!nuevaCategoria.value.trim()) {
    errorNuevoCategoria.value = 'El nombre de la categoría es requerido';
    return;
  }

  const categoria = { nombre: nuevaCategoria.value.trim() };

  // Enviar solicitud POST para agregar una nueva categoría
  router.post('/categoriasi', categoria, {
    onSuccess: (response) => {
      console.log('Categoría agregada con éxito');

      // Obtener el último elemento de response.props.categorias
      const lastCategory = response.props.categorias.slice(-1)[0];

      // Actualizar el estado con la nueva categoría
      form.categorias = [
        ...form.categorias,
        lastCategory
      ];

      // Inicializar nuevo ítem para la nueva categoría
      nuevoItem[lastCategory.id] = { nombre: '', precio: '', cantidad: '' };

      // Limpiar el campo de entrada y el mensaje de error
      nuevaCategoria.value = '';
      errorNuevoCategoria.value = '';
    },
    onError: (errors) => {
      console.error('Error al agregar la categoría:', errors);
      errorNuevoCategoria.value = 'Hubo un problema al agregar la categoría. Inténtalo de nuevo.';
    }
  });
};


</script>

<template>
  <AppLayout title="Inventario">

    <div class="py-4">
      <div class="max-w mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg">
          <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form @submit.prevent="submit">
              <!--INVENTARIO ADMINISTRACION-->
              <div v-if="categorias">
                <div v-for="categoria in form.categorias" :key="categoria.id" class="mb-4">
                  <h2 class="text-xl font-bold">{{ categoria.nombre }}</h2>
                  <div v-if="categoria.items" class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 gap-4">
                    <div v-for="item in categoria.items" :key="item.id"
                      class="bg-white shadow rounded border border-gray-300 p-4">

                      <label class="block overflow-hidden">
                        <div class="flex justify-between items-center lg:flex-row flex-col">
                          <span  class="font-medium">Cantidad de {{
            item.cantidad
          }}:</span>
                          <span  class="font-medium">Nombre:</span>
                        </div>

                        
                        <div>
                          <input type="text" v-model.trim="item.nombre"
                          class="mt-1 block w-full border rounded p-2 border-gray-300" />
                          <div class="flex items-center">
                            <p class="px-2">$</p>
                            <input type="number" v-model.number="item.precio" :min="0"
                            class="mt-1 block w-full border rounded p-2 border-gray-300" />
                            <input  type="number" v-model.number="item.cantidad"
                            class="mt-1 block w-full border rounded p-2" :min="0" step="0.10" />
                          </div>
                        </div>
                        <div v-if="$page.props.auth.user.sucursal_id == 0"
                          class="flex flex-col gap-1 mt-2 justify-center items-center">
                          <span @click="editarItem(categoria.id, item.id)"
                            class="text-center w-fit text-xs px-10 py-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg cursor-pointer">Actualizar</span>
                          <span @click="eliminarItem(categoria.id, item.id)"
                            class="text-center w-fit text-xs px-11 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg cursor-pointer">Eliminar</span>
                        </div>
                        <div v-if="errorNuevoItem[categoria.id]" class="text-red-500 mt-2">{{
            errorNuevoItem[categoria.id]
          }}</div>
                      </label>
                    </div>
                    <div v-if="$page.props.auth.user.sucursal_id == 0"
                      class="bg-white shadow border border-gray-300 rounded p-4 items-center flex">
                      <label class="block h-full">
                        <div class="flex justify-between w-full items-center">
                          <span class="font-medium text-gray-500">Nuevo item</span>

                        </div>
                        <input type="text" placeholder="Nombre del item"
                          class="mt-1 block w-full border border-gray-300 rounded p-2"
                          v-model.trim="nuevoItem[categoria.id].nombre" />
                        <input type="number" placeholder="$0.0"
                          class="mt-1 block w-full border border-gray-300 rounded p-2"
                          v-model.number="nuevoItem[categoria.id].precio" step="0.10" />
                        <input type="number" placeholder="0.0"
                        class="mt-1 block w-full border border-gray-300 rounded p-2"
                        v-model.number="nuevoItem[categoria.id].cantidad" step="0.10" />
                        <div class="flex justify-center items-center w-full mt-2">
                          <span @click="agregarItem(categoria.id)"
                            class="text-center text-xs px-10 py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg cursor-pointer">Agregar</span>
                        </div>
                        <div v-if="errorNuevoItemCat[categoria.id]" class="text-red-500 mt-2">{{
            errorNuevoItemCat[categoria.id] }}</div>
                      </label>
                    </div>
                  </div>
                </div>
              </div>


              <div v-if="$page.props.auth.user.sucursal_id === 0"
                class="py-4 my-8 border-t-2 flex flex-col w-fit gap-2">
                <label for="categoria">Nueva categoria:</label>
                <input v-model.trim="nuevaCategoria" type="text" class="rounded-lg" placeholder="Nombre">
                <span @click.prevent="handleAddNewCategory"
                  class="bg-blue-500 hover:bg-blue-600 cursor-pointer text-white px-4 py-2 rounded-xl text-center">
                  Agregar
                </span>
                <div v-if="errorNuevoCategoria" class="text-red-500  text-center">{{ errorNuevoCategoria }}</div>
              </div>

              <div v-if="$page.props.auth.user.sucursal_id > 0" class="w-full flex justify-end">
                <button type="submit" class="py-2 px-3 rounded-lg bg-orange-500 text-white font-bold">Actualizar
                  Inventario</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>