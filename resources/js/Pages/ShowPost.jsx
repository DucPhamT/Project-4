import NavBar from "@/Components/NavBar";
import { useState, useEffect, useCallback } from "react";
import "../../css/pages/ShowPost.css";
import PostTableRow from "@/Components/PostTableRow";
import axios from "axios";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
const headers = [
  {
    id: 1,
    label: "Title",
  },
  {
    id: 2,
    label: "Author",
  },
  {
    id: 3,
    label: "Category",
  },
  {
    id: 4,
    label: "Created_at",
  },
  {
    id: 5,
    label: "Action",
  },
];
export default function CreatePost({ user, token, categories }) {
  const [data, setData] = useState([]);
  const [error, setError] = useState(null);
  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get("/api/posts/get-post");
        setData(response.data.post);
      } catch (err) {
        setError(err.message);
        console.log(err);
      }
    };

    fetchData();
  }, []);

  return (
    <>
      <NavBar />
      <Table className="content-table my-[25px] w-full select-none">
        {/* header*/}
        <TableHeader>
          <TableRow className="min-w-[400px] bg-[#009879] text-left text-[30px] text-white">
            {headers.map((header) => (
              <TableHead key={header.id} className="px-[3px]">
                {header.label}
              </TableHead>
            ))}
          </TableRow>
        </TableHeader>

        {/* body*/}
        <TableBody>
          {data.map((post) => (
            <PostTableRow key={post.id} post={post} className="" />
          ))}
        </TableBody>
        <TableCaption>A list of Posts</TableCaption>
      </Table>
    </>
  );
}
