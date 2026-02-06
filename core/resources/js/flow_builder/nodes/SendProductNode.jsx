import { useState, useEffect } from "react";
import NodeWrapper from "./NodeWrapper.jsx";
import { Position } from "reactflow";

export default function SendProductNode({ id, data, setNodes }) {
    const handles = [{ type: "target", position: Position.Left }];
    const [body, setBody] = useState(data.body || "");
    const [footer, setFooter] = useState(data.footer || "");
    const [catalogId, setCatalogId] = useState(data.catalog_id || "");
    const [productRetailerId, setProductRetailerId] = useState(data.product_retailer_id || "");

    useEffect(() => {
        setNodes((nds) =>
            nds.map((node) =>
                node.id === id
                    ? { ...node, data: { ...node.data, body, footer, catalog_id: catalogId, product_retailer_id: productRetailerId } }
                    : node
            )
        );
    }, [body, footer, catalogId, productRetailerId, id, setNodes]);

    const handleBodyChange = (value) => {
        if (body.length > 1024) {
            notify("error", "Body text cannot exceed 1024 characters.");
            return;
        }
        setBody(value);
    };

    const handleFooterChange = (value) => {
        if (footer.length > 60) {
            notify("error", "Footer text cannot exceed 60 characters.");
            return;
        }
        setFooter(value);
    };

    return (
        <NodeWrapper
            id={id}
            setNodes={setNodes}
            title={
                <h6 className="mb-0">
                    <i className="las la-shopping-cart"></i> Single Product
                </h6>
            }
            content={
                <div style={{ minWidth: "280px" }}>
                    <label className="form-label">Catalog ID <span className="text-danger">*</span></label>
                    <input
                        type="text"
                        className="form-control form--control mb-2"
                        placeholder="e.g. 1234567890"
                        value={catalogId}
                        onChange={(e) => setCatalogId(e.target.value)}
                    />

                    <label className="form-label">Product Retailer ID <span className="text-danger">*</span></label>
                    <input
                        type="text"
                        className="form-control form--control mb-2"
                        placeholder="e.g. shirt_001"
                        value={productRetailerId}
                        onChange={(e) => setProductRetailerId(e.target.value)}
                    />

                    <label className="form-label">Body Text</label>
                    <textarea
                        className="form-control form--control mb-2"
                        rows={2}
                        placeholder="Enter message body..."
                        value={body}
                        maxLength={1024}
                        onChange={(e) => handleBodyChange(e.target.value)}
                    />

                    <label className="form-label">Footer Text</label>
                    <input
                        type="text"
                        className="form-control form--control mb-3"
                        placeholder="Enter footer text..."
                        value={footer}
                        maxLength={60}
                        onChange={(e) => handleFooterChange(e.target.value)}
                    />
                </div>
            }
            handles={handles}
        />
    );
}
