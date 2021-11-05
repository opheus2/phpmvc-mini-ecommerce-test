import Alpine from "alpinejs";
import persist from "@alpinejs/persist";

Alpine.plugin(persist);
window.Alpine = Alpine;

Alpine.store("app", {
  products: [],
  user: Alpine.$persist({}),
  totalCartItems: Alpine.$persist(0),
  totalItemsCost: Alpine.$persist(0),
});

Alpine.start();
