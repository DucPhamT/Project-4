import ApplicationLogo from "./ApplicationLogo";
import { Link } from "@inertiajs/react";
import { router } from "@inertiajs/react";
import Logo from "../../../public/blog_logo.svg";
import { Button } from "@headlessui/react";
import Dropdown from "../Components/Dropdown";
const dropdownPost = [
  { label: "Create Post", href: "/create-post" },

  { label: "Posts", href: "/show-posts" },
];

export default function NavBar() {
  return (
    <>
      <div className="grid grid-cols-3 items-center border-4 border-red-300">
        {/* Logo */}
        <span className="flex justify-start">
          <img src={Logo} alt="Logo" className="h-[70px]" />
        </span>

        {/* main navbar */}
        <div className="flex justify-center">
          <Dropdown title="Post" items={dropdownPost}></Dropdown>
        </div>

        {/* log_out */}
        <div className="flex justify-end">
          <button className="mr-2 border border-[#333] p-[4px]">
            <Link href="/logout" method="post">
              Log out
            </Link>
          </button>
        </div>
      </div>
    </>
  );
}
