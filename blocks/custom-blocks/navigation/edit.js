import { SelectControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";

function Edit({ attributes, setAttributes }) {
  const menus = useSelect((select) => select("core").getEntityRecords("root", "menu"), []);

  if (!menus) {
    return "Caricamento...";
  }

  if (!menus.length) {
    return "Nessun menù disponibile. Crea un menù.";
  }

  return (
    <div className="navigation-edit">
      <SelectControl
        label="Scegli il Menu Desktop"
        value={attributes.selectedDesktopMenuId}
        options={[{ value: "", label: "Nessuno" }, ...menus.map((menu) => ({ value: menu.id, label: menu.name }))]}
        onChange={(selectedDesktopMenuId) => setAttributes({ selectedDesktopMenuId })}
      />
      <SelectControl
        label="Scegli il Menu Mobile"
        value={attributes.selectedMobileMenuId}
        options={[{ value: "", label: "Nessuno" }, ...menus.map((menu) => ({ value: menu.id, label: menu.name }))]}
        onChange={(selectedMobileMenuId) => setAttributes({ selectedMobileMenuId })}
      />
    </div>
  );
}

export default Edit;
