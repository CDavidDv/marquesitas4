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
  router.post('/inventario', form, {
    onSuccess: () => {
      console.log('Inventario actualizado con éxito');
    },
    onError: (errors) => {
      console.error('Error al actualizar el inventario:', errors);
    }
  });
};

const agregarIngrediente = () => {
  const nombreInput = document.getElementById('nombre');
  const nombre = nombreInput ? nombreInput.value.trim() : '';

  const precioInput = document.getElementById('precio');
  const precio = precioInput ? precioInput.value.trim() : '';

  if (!nombre || !precio) {
    errorNuevoIngrediente.value = 'Nombre y precio son requeridos'
    return;
  }

  const nuevoIngrediente = { nombre: nombre, precio: parseFloat(precio), cantidad: 0 };

  router.post('/ingredientes', {
    nombre: nombre,
    precio: parseFloat(precio)
  }, {
    onSuccess: (response) => {
      console.log('Ingrediente agregado con éxito');
      nombreInput.value = '';
      precioInput.value = '';
      const lastIngrediente = response.props.ingredientes[response.props.ingredientes.length - 1];

      // Crear el array actualizado combinando los datos existentes con el nuevo ítem
      form.ingredientes = [
        ...form.ingredientes,  // Mantener los datos existentes
        {
          ...lastIngrediente
        }
      ];
    },
    onError: (errors) => {
      console.error('Error al agregar el ingrediente:', errors);
    }
  });
};

const agregarBebida = () => {
  const nombreInput = document.getElementById('nombreB');
  const nombre = nombreInput ? nombreInput.value.trim() : '';
  const precioInput = document.getElementById('precioB');
  const precio = precioInput ? precioInput.value.trim() : '';

  if (!nombre || !precio) {
    errorNuevoBebida.value = 'Nombre y precio son requeridos';
    return;
  }

  router.post('/bebidas', {
    nombre: nombre, precio: parseFloat(precio), cantidad: 0
  }, {
    onSuccess: (response) => {
      nombreInput.value = '';
      precioInput.value = '';

      const lastBebida = response.props.bebidas[response.props.bebidas.length - 1];
      form.bebidas = [
        ...form.bebidas,
        { ...lastBebida }
      ];
    },
    onError: (errors) => {
      console.error('Error al agregar la bebida:', errors);
    }
  });
};


const editarIngrediente = (id) => {
  const ingrediente = form.ingredientes.find(i => i.id === id);
  if (ingrediente) {
    if (!ingrediente.nombre || ingrediente.nombre.trim() === '') {
      console.log(ingrediente.nombre)
      error.value = 'El nombre está vacío o solo contiene espacios';
      return;
    }
    if (!ingrediente.precio || isNaN(ingrediente.precio) || Number(ingrediente.precio.value) === 0) {
      error.value = 'El precio está vacío, no es válido o es 0';
      return;
    }

    router.put(`/ingredientes/${id}`, ingrediente, {
      onSuccess: () => {
        console.log('Ingrediente actualizado con éxito');
      },
      onError: (errors) => {
        console.error('Error al actualizar el ingrediente:', errors);
      }
    });
  }
};

const editarBebida = (id) => {
  const bebida = form.bebidas.find(b => b.id === id);
  if (bebida) {
    if (!bebida.nombre || bebida.nombre.trim() === '') {
      console.log(bebida.nombre)
      error.value = 'El nombre está vacío o solo contiene espacios';
      return;
    }
    if (!bebida.precio || isNaN(bebida.precio) || Number(bebida.precio.value) === 0) {
      error.value = 'El precio está vacío, no es válido o es 0';
      return;
    }
    router.put(`/bebidas/${id}`, bebida, {
      onSuccess: () => {
        console.log('Bebida actualizada con éxito');
      },
      onError: (errors) => {
        console.error('Error al actualizar la bebida:', errors);
      }
    });
  }
};

const eliminarIngrediente = (id) => {
  router.delete(`/ingredientes/${id}`, {
    onSuccess: () => {
      form.ingredientes = form.ingredientes.filter(i => i.id !== id);
      console.log('Ingrediente eliminado con éxito');
    },
    onError: (errors) => {
      console.error('Error al eliminar el ingrediente:', errors);
    }
  });
};

const eliminarBebida = (id) => {
  router.delete(`/bebidas/${id}`, {
    onSuccess: () => {
      form.bebidas = form.bebidas.filter(b => b.id !== id);
      console.log('Bebida eliminada con éxito');
    },
    onError: (errors) => {
      console.error('Error al eliminar la bebida:', errors);
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

    router.post('/items', {
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
  router.delete(`/items/${itemId}`, {
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
  const categoria = form.categorias.find(c => c.id === categoriaId);
  const item = categoria ? categoria.items.find(i => i.id === itemId) : null;

  if (item) {
    // Validaciones
    if (!item.nombre || item.nombre.trim() === '') {
      errorNuevoItem.value[itemId] = 'El nombre está vacío o solo contiene espacios';
      return;
    }
    if (!item.precio || isNaN(item.precio) || Number(item.precio) === 0) {
      errorNuevoItem.value[itemId] = 'El precio está vacío, no es válido o es 0';
      return;
    }

    // Enviar solicitud PUT para actualizar el ítem
    router.put(`/items/${itemId}`, item, {
      onSuccess: (response) => {
        console.log('Item actualizado con éxito');

        // Obtener la última categoría con los ítems actualizados
        const updatedCategory = response.props.categorias.find(c => c.id === categoriaId);
        if (updatedCategory) {
          form.categorias = form.categorias.map(c => 
            c.id === categoriaId ? updatedCategory : c
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
  router.post('/categorias', categoria, {
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
    <template #header>
      <div class="flex justify-between flex-col md:flex-row">
        <div>
          <h1 class="text-xl font-bold">Inventario - Sucursal {{ sucursal }}</h1>
        </div>
      </div>
    </template>

    <div class="py-4">
      <div class="max-w mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg">
          <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form @submit.prevent="submit">
              <div class="mb-4">
                <div class="flex flex-col md:flex-row gap-2">
                  <h2 class="text-xl font-bold mb-4">Ingredientes</h2>
                  <div v-if="error" class="text-red-500 font-bold mt-2">{{ error }}</div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 gap-4">
                  <div v-for="ingrediente in form.ingredientes" :key="ingrediente.id"
                    class="bg-white border border-gray-300 shadow rounded-md p-4  ">
                    <label class="block overflow-hidden">
                      <div class="flex justify-between items-center lg:flex-row flex-col">

                        <span v-if="$page.props.auth.user.sucursal_id > 0"
                          class=" font-light text-sm lg:text-base">Cantidad
                          de {{ ingrediente.nombre }}:</span>
                        <span v-else class=" font-light text-sm lg:text-base">Nombre: </span>
                      </div>

                      <input v-if="$page.props.auth.user.sucursal_id > 0" type="number"
                        v-model.number="form.ingredientes.find(i => i.id === ingrediente.id).cantidad"
                        class="mt-1 block w-full border rounded p-2" step="0.10" />
                      <div v-else class="">
                        <input type="text" v-model.trim="ingrediente.nombre"
                          class="mt-1 block w-full border border-gray-300 rounded p-2" />
                        <p>Precio: </p>
                        <div class="flex items-center">
                          <p class="px-2">$</p>
                          <input type="number"
                            v-model.number="form.ingredientes.find(i => i.id === ingrediente.id).precio"
                            class="mt-1 block w-full border border-gray-300 rounded p-2 text-right" :min="0"
                            step="0.10" />
                        </div>
                      </div>
                      <div v-if="$page.props.auth.user.sucursal_id == 0"
                        class="flex flex-col gap-1 pt-2 justify-center items-center">
                        <span @click="editarIngrediente(ingrediente.id)"
                          class=" text-center text-xs px-10 py-2 w-fit bg-blue-500 hover:bg-blue-600 text-white  font-bold rounded-lg cursor-pointer">Actualizar</span>
                        <span @click="eliminarIngrediente(ingrediente.id)"
                          class="text-center text-xs px-11 py-2 w-fit bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg cursor-pointer">Eliminar</span>
                      </div>
                    </label>
                  </div>
                  <div v-if="$page.props.auth.user.sucursal_id == 0"
                    class="bg-white shadow rounded border border-gray-300 p-4 items-center flex ">
                    <label class="block w-full">
                      <span class="font-medium text-gray-500">Nuevo item</span>
                      <input id="nombre" type="text" placeholder="Ingrediente"
                        class="mt-1 block w-full border border-gray-300 rounded p-2" />
                      <input id="precio" type="number" placeholder="$0.0"
                        class="mt-1 block w-full border border-gray-300 rounded p-2" min="0" step="0.10" />
                      <div class="flex justify-center w-full items-center">
                        <div class="flex flex-col gap-1 mt-2">
                          <span @click="agregarIngrediente"
                            class="text-center text-xs px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg cursor-pointer">Agregar</span>
                          <div v-if="errorNuevoIngrediente" class="text-red-500  mt-2">{{ errorNuevoIngrediente }}</div>
                        </div>
                      </div>
                    </label>
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <h2 class="text-xl font-bold">Bebidas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 gap-4">
                  <div v-for="bebida in form.bebidas" :key="bebida.id"
                    class="bg-white shadow rounded border border-gray-300 p-4">
                    <label class="block overflow-hidden">
                      <div class="flex justify-between items-center lg:flex-row flex-col">
                        <span v-if="$page.props.auth.user.sucursal_id > 0" class="font-medium">Cantidad de {{
            bebida.nombre
          }}:</span>
                        <span v-else class="font-medium">Nombre:</span>

                      </div>

                      <input v-if="$page.props.auth.user.sucursal_id > 0" type="number"
                        v-model.number="form.bebidas.find(b => b.id === bebida.id).cantidad"
                        class="mt-1 block w-full border rounded p-2" :min="0" step="0.10" />

                      <div v-else>
                        <input type="text" v-model.trim="bebida.nombre"
                          class="mt-1 block w-full border rounded p-2 border-gray-300" />
                        <div class="flex items-center">
                          <p class="px-2">$</p>
                          <input type="number" v-model.number="bebida.precio" :min="0"
                            class="mt-1 block w-full border rounded p-2 border-gray-300" />
                        </div>
                      </div>
                      <div v-if="$page.props.auth.user.sucursal_id == 0"
                        class="flex flex-col gap-1 mt-2 justify-center items-center ">
                        <span @click="editarBebida(bebida.id)"
                          class=" text-center w-fit text-xs px-10 py-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg cursor-pointer">Actualizar</span>
                        <span @click="eliminarBebida(bebida.id)"
                          class="text-center w-fit text-xs px-11 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg cursor-pointer">Eliminar</span>
                      </div>
                    </label>

                  </div>
                  <div v-if="$page.props.auth.user.sucursal_id == 0"
                    class="bg-white shadow border border-gray-300 rounded p-4 items-center flex ">
                    <label class="block h-full ">
                      <div class="flex justify-between w-full items-center">
                        <span class="font-medium text-gray-500">Nuevo item</span>
                      </div>
                      <input id="nombreB" type="text" placeholder="Bebida"
                        class="mt-1 block w-full border border-gray-300 rounded p-2" :min="0"
                        v-model.trim="form.bebidas.nombre" />
                      <input id="precioB" type="number" placeholder="$0.0"
                        class="mt-1 block w-full border border-gray-300 rounded p-2" :min="0"
                        v-model.number="form.bebidas.precio" step="0.10" />
                      <div class="flex justify-center items-center w-full mt-2">
                        <span @click="agregarBebida"
                          class=" text-center text-xs px-10 py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg cursor-pointer">Agregar</span>
                      </div>
                      <div v-if="errorNuevoBebida" class="text-red-500  mt-2">{{ errorNuevoBebida }}</div>
                    </label>
                  </div>
                </div>
              </div>
              <!--CATEGORIAS-->
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