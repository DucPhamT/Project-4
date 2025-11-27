import { useState, useEffect, useCallback } from "react";
import "../../css/pages/ShowPost.css";
import { MdDeleteForever } from "react-icons/md";
import { GrUpdate } from "react-icons/gr";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Button } from "@headlessui/react";
import { router } from "@inertiajs/react";

const formatDate = (dateString) => {
  if (!dateString) return "";

  const date = new Date(dateString);
  const day = String(date.getDate()).padStart(2, "0");
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const year = date.getFullYear();

  return `${day}/${month}/${year}`;
};

export default function PostTableRow({ post }) {
  const handleDelete = () => {
    if (confirm("Are you sure you want to delete this post?")) {
      router.visit(`/delete-post/${post.id}`, { method: "delete" });
    }
  };

  const handleEdit = () => {
    router.visit(`/edit-post/${post.id}`, { method: "get" });
  };

  return (
    <>
      <TableRow className="body-table-row even:bg-[#8c747f] even:text-[#fff]">
        <TableCell>{post.title}</TableCell>
        <TableCell>{post.user.name}</TableCell>
        <TableCell>
          {post.categories.map((category) => category.name).join(", ")}
        </TableCell>
        <TableCell>{formatDate(post.created_at)}</TableCell>

        <TableCell>
          <div className="flex items-center gap-[10px]">
            <Button onClick={handleEdit} className="text-[20px]">
              <GrUpdate />
            </Button>
            <Button onClick={handleDelete} className="text-[35px]">
              <MdDeleteForever />
            </Button>
          </div>
        </TableCell>
      </TableRow>
    </>
  );
}
