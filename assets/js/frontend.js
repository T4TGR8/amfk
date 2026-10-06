document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector("[data-programs]");

  if (!container) {
    return;
  }

  const filter = container.querySelector("[data-filter]");
  const programs = container.querySelectorAll("[data-program]");
  const noResults = container.querySelector("[data-no-results]");

  if (!filter || !programs.length) {
    return;
  }

  const filterPrograms = () => {
    const selectedFilter = filter.value;
    let visibleCount = 0;

    programs.forEach((program) => {
      const status = program.dataset.status;

      const matches =
        selectedFilter === "all" ||
        (selectedFilter === "available" &&
          ["available", "few_spots"].includes(status)) ||
        (selectedFilter === "not_available" &&
          ["finished", "full", "cancelled", "unbookable"].includes(status));

      program.style.display = matches ? "" : "none";

      if (matches) {
        visibleCount++;
      }
    });

    if (noResults) {
      noResults.style.display = visibleCount === 0 ? "" : "none";
    }
  };

  filter.addEventListener("change", filterPrograms);

  filterPrograms();
});
