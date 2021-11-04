import Alpine from "alpinejs";
import persist from "@alpinejs/persist";

Alpine.plugin(persist);
window.Alpine = Alpine;

Alpine.store("app", {
  products: [],
  totalCartItems: Alpine.$persist(0),
});

Alpine.start();
