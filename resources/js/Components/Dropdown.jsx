import { Link } from "@inertiajs/react";
import { IoIosArrowDown } from "react-icons/io";
import { useState } from "react";
import { Button } from "@headlessui/react";

const Dropdown = ({ items, title }) => {
  const [open, setOpen] = useState(false);

  return (
    <div
      className="group relative inline-block"
      onMouseEnter={() => setOpen(true)}
      onMouseLeave={() => setOpen(false)}
    >
      <Button>
        <div className="flex items-center gap-2">
          <span>{title}</span>
          <span
            className={`block transition-transform duration-300 ${
              open ? "rotate-180" : "rotate-0"
            } group-hover:rotate-180`}
          >
            <IoIosArrowDown color="#635FC7" size={15} />
          </span>
        </div>
      </Button>

      {/* Dropdown content */}
      <ul className="absolute left-0 top-full mt-2 w-40 space-y-2 rounded border bg-gray-400 opacity-0 transition-all duration-200 group-hover:visible group-hover:opacity-100">
        {items.map((item) => (
          <li key={item.label}>
            <Link href={item.href} method="get">
              <div className="cursor-pointer px-4 py-2 hover:bg-red-300">
                {item.label}
              </div>
            </Link>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Dropdown;
